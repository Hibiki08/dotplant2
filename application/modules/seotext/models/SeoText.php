<?php

namespace app\modules\seotext\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\City;
use app\models\Subdomain;
use app\modules\shop\models\Category;
use app\modules\shop\models\Product;
use app\modules\shop\models\ProductCategory;
use voskobovich\linker\LinkerBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\seotext\models\SeoCityVarItem;

/**
 * This is the model class for table "seo_texts".
 *
 * @property integer $id
 * @property string $text
 * @property integer $published
 */
class SeoText extends ActiveRecord
{
    public $preparedText;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo_texts}}';
    }

    public function behaviors()
    {
        return [
            'manyToMany' => [
                'class' => LinkerBehavior::className(),
                'relations' => [
                    'subdomain_ids' =>[
                        'subdomains',
                        'updater' => [
                            'viaTableAttributesValue' => [
                                'exclude' => 0,
                            ],
                            'viaTableCondition' => [
                                'exclude' => 0,
                            ],
                        ],
                    ],
                    'excl_subdomain_ids' => [
                        'subdomainsExclude',
                        'updater' => [
                            'viaTableAttributesValue' => [
                                'exclude' => 1,
                            ],
                            'viaTableCondition' => [
                                'exclude' => 1,
                            ],
                        ],
                    ],

                    'categoryIds' => ['categories',],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'description', 'subdomain_ids'], 'required'],
            [
                ['published', 'inProduct', 'inCategory',], 
                'integer',
            ],

            [['text'], 'string', 'max' => 19999],
            [['description'], 'string', 'max' => 1024],

            [
                [
                    //'city_ids',
                    'subdomain_ids',
                    //'category_ids', 'product_ids',
                    //'excl_city_ids',
                    'excl_subdomain_ids',
                    //'excl_category_ids', 'excl_product_ids',
                ], 
                'each', 
                'rule' => ['integer'],
            ],
            ['categoryIds', 'each', 'rule' => ['integer'], ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'published' => 'Опубликовано',
            'text' => 'Текст для вывода',
            'description' => 'Служебное описание',
            //'excludeCity' => 'Исключить города',
            'subdomain_ids' => 'Субдомены для включения',
            'excl_subdomain_ids' => 'Субдомены для исключения',
            'inProduct' => 'Включить для товаров', 
            'inCategory' => 'Включить для категорий', 

            /*
            'city_ids' => 'Города для исключения/включения',
            'category_ids' => 'Категории для включения',
            'product_ids' => 'Товары для включения',
            'excl_city_ids' => 'Города для исключения',
            'excl_category_ids' => 'Категории для исключения',
            'excl_product_ids' => 'Товары для исключения',
            */
        ];
    }

    public function getSubdomains() {
        return $this->hasMany(Subdomain::className(),['id' => 'subdomain_id'])
            ->viaTable('{{%seo_texts_subdomains}}',['seo_text_id' => 'id'],
            function ($query) {
                $query->andWhere([
                    'exclude' => 0,
                ]);
                return $query;
            });
    }

    public function getSubdomainsData() {
        $data = [];

        if($subdomains = Subdomain::find()->all()) {
            foreach ($subdomains as $subdomain) {
                $data[$subdomain->id] = $subdomain->title . ' (' . $subdomain->domain_prefix . ')';
            }
        }

        return $data;
    }

    public function getSubdomainsExclude() {
        return $this->hasMany(Subdomain::className(),['id' => 'subdomain_id'])
            ->viaTable('{{%seo_texts_subdomains}}',['seo_text_id' => 'id'],
            function ($query) {
                $query->andWhere([
                    'exclude' => 1,
                ]);
                return $query;
            });
    }

    public function getCategories() {
        return $this->hasMany(Category::className(),['id' => 'category_id'])
            ->viaTable('{{%seo_texts_categories}}',['seo_text_id' => 'id']);
    }

    public static function getSeoTextInCategory($cityId, $catId, $allowEmptyVars = true) {
        return Yii::$app->db->cache(function($db) use ($cityId, $catId, $allowEmptyVars) {
            return self::getPrepareAllTexts($cityId, $catId, false, $allowEmptyVars, 'inCategory');
        }, (3600 * 60 * 24 * 7));
    }
    
    public static function getSeoTextInProduct($cityId, $productId, $allowEmptyVars = true) {
        return Yii::$app->db->cache(function($db) use ($cityId, $productId, $allowEmptyVars) {
            if(!$product = Product::findOne($productId)) {
                Yii::error("ТОвар не найден id = $id");
                return [];
            }
    
            $catId = $product->mainCategory->id;
            
            return self::getPrepareAllTexts($cityId, $catId, $productId, $allowEmptyVars, 'inProduct');
        }, (3600 * 60 * 24 * 7));
    }

    public static function getPrepareAllTexts($cityId, $catId, $productId, $allowEmptyVars, $type = 'inCategory') {
        $texts = self::find()
            ->where([
                'published' => 1,
                $type => 1,
                'category.id' => $catId,
            ])
            ->joinWith('categories')
            ->orderBy(new \yii\db\Expression('RAND()'))
            ->limit(1)
            ->all();

        $result = [];

        foreach($texts as $text) {
            $result[] = $text->prepareCityText($cityId, $catId, $productId, $allowEmptyVars);
        }

        return $result;
    } 

    public function prepareCityText($cityId, $catId, $productId = null, $allowEmptyVars = true) {
        $search = [];
        $replace = [];

        $cityVars = SeoCityVarItem::find()->where(['city_id' => $cityId])->with('var')->all();
        if(!$cityVars) {
            Yii::error('ДЛя города нет seo выражений');
        }

        $mergedArray = self::arraysMergeHelper($search, $replace, $cityVars);
        $search = $mergedArray['search'];
        $replace = $mergedArray['replace'];


        $categoryVars = SeoCategoryVarItem::find()->where(['category_id' => $catId])->with('var')->all();
        if(!$categoryVars) {
            Yii::error("Для категории нет seo выражений catId = $catId");
            if(!$allowEmptyVars) return '';
        }

        $mergedArray = self::arraysMergeHelper($search, $replace, $categoryVars);
        $search = $mergedArray['search'];
        $replace = $mergedArray['replace'];

        if(!$productId) {
            if(!($productId = self::getRndProductInCat($catId))) {
                return '';
            } else {
                $productCategory = ProductCategory::find()->where(['category_id' => $catId])->orderBy('RAND()')->one();
                if(!$productCategory) {
                    Yii::error('Не найдена товар в категории');
                    return '';
                }        
                $productId = $productCategory->object_model_id;
            }
        }
        

        $productVars = SeoProductVarItem::find()->where(['product_id' => $productId])->with('var')->all();
        
        /**
         * 
         *if(!$productVars) {
         *    Yii::error('Для товара нет seo выражений');
         *    if(!$allowEmptyVars) return '';
         *}
         */
        
        $product = Product::findOne($productId);
        if(!$product) {
            return '';
        }

        $search[] = '{product_name}';
        $replace[] = $product->name;
        
        $search[] = '{product_url}';
        $replace[] = Url::to(
            [
                '@product',
                'model' => $product,
                'category_group_id' => $catId,
            ]
        );
        
        if($category = Category::findOne($catId)) {
            $search[] = '{cat_url}';
            $replace[] = Url::to('/' . $category->getUrlPath());
        }

        foreach ($productVars as $var) {
            if(!ArrayHelper::isIn($var->var->word, $search, true)) {
                $search[] = '{' . $var->var->word . '}';
                $replace[] = $var->seo_word;
            } else {
                //Yii::error('Дублирование строк для замены');
                //В принципе, это может так быть.
            }
        }

        $result = str_replace($search, $replace, $this->text);

        return $result;
    }

    public static function getRndProductInCat($catId) {
        return ProductCategory::find()
            ->where(['category_id' => $catId])
            ->orderBy('RAND()')
            ->cache(3600 * 24)
            ->one();
    }

    public static function arraysMergeHelper($search, $replace, $vars) {
        foreach ($vars as $var) {
            if(!ArrayHelper::isIn($var->var->word, $search, true)) {
                $search[] = '{' . $var->var->word . '}';
                $replace[] = $var->seo_word;
            } else {
                Yii::error('Дублирование строк для замены');
            }
        }
        return [
            'search' => $search, 
            'replace' => $replace
        ];
    }
}
