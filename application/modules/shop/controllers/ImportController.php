<?php

namespace app\modules\shop\controllers;

use yii;
use yii\web\Controller;
use app\modules\core\behaviors\DisableRobotIndexBehavior;
use app\modules\image\models\Image;
use app\modules\shop\models\Category;
use app\modules\shop\models\Product;
use app\modules\shop\models\ProductEav;
use app\models\PropertyGroup;
use app\models\Property;
use app\models\PropertyStaticValues;
use app\modules\shop\models\ProductCategory;
use app\models\BaseObject;
use app\models\ObjectStaticValues;
use app\models\ObjectPropertyGroup;
use app\models\PropertyHandler;
use app\components\Helper;

/**
 * Class CartController
 * @package app\modules\shop\controllers
 */
class ImportController extends Controller
{

    protected $products = [];
    protected $properties = [];
    protected $values = [];
    protected $textHandlerId;
    protected $selectHandlerId;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => DisableRobotIndexBehavior::className(),
                'setSameOrigin' => false
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
//        copy('http://stripmag.ru/datafeed/p5s_assort.csv', $_SERVER['DOCUMENT_ROOT'] . '/files/p5s_assort.csv');
        $this->createCategory();
        return $this->render('index');
    }

    /*
     * создаем категории
     */
    private function createCategory()
    {
        $this->layout = false;

        $data = file($_SERVER['DOCUMENT_ROOT'] . '/files/p5s_assort.csv');
        $start = 1;
//        $next = $start+1;
        $dataSize = sizeof($data);
        for ($i = $start; $i < $dataSize; $i++) {
            $line = explode(';', str_replace('"', '', $data[$i]));
            // Запись основной категории
//            $lastId = $this->saveCategory($line[1], 1, $i);
//            for ($m = $start; $m < $dataSize; $m++) {
//                $subLine = explode(';', str_replace('"', '', $data[$m]));
//                if ($line[1] == $subLine[1]) {
//                    // добавим подгруппу
////                    echo  $line[1] . ' - ' . $subLine[2] . '<br />';
//                    $lastId = $this->saveCategory($subLine[2], $lastId, $m);
//                    // добавим товар
//                    $this->productSave($subLine, $lastId);
//                }
//            }
        }
    }

    /*
     * сохранение товара
     */
    private function productSave($productData, $categoryId)
    {
        /*
        $productObject = BaseObject::getForClass(Product::className());
        /** @var PropertyHandler $handler *
        $handler = PropertyHandler::findOne(['handler_class_name' => 'app\properties\handlers\text\TextProperty']);
        if (!is_null($handler)) {
            $this->textHandlerId = $handler->id;
        }
        $handler = PropertyHandler::findOne(['handler_class_name' => 'app\properties\handlers\select\SelectProperty']);
        if (!is_null($handler)) {
            $this->selectHandlerId = $handler->id;
        }

        // группа свойств
        if ($model = PropertyGroup::find()->where(['object_id' => $productObject->id])->one()) {
            $lstId = $model->id;
        } else {
            $model = new PropertyGroup();
            $lstId = 0;
        }
        $model->object_id = $productObject->id;
        $model->name = 'Общая группа свойств';
        $model->save();

        if ($lstId == 0) {
            $commonGroupId = Yii::$app->db->getLastInsertID();
        } else {
            $commonGroupId = $lstId;
        }


        // свойства
        if ($model = Property::find()->where(['property_group_id' => $commonGroupId])->one()) {
            $lstId = $model->id;
        } else {
            $model = new Property();
            $lstId = 0;
        }

        $model->property_group_id = $commonGroupId;
        $model->name = 'Производитель';
        $model->key = 'vendor';
        $model->property_handler_id = ($this->selectHandlerId != null) ? $this->selectHandlerId : 0;
        $model->handler_additional_params = '{}';
        $model->has_static_values = 1;
        $model->has_slugs_in_values = 1;
        $model->save();

        if ($lstId == 0) {
            $this->properties['vendor'] = Yii::$app->db->getLastInsertID();
        } else {
            $this->properties['vendor'] = $lstId;
        }

        $staticProperties = [
            "Производитель",
            "Артикул производителя",
            "Цена (Розница)",
            "Можно купить",
            "На складе",
            "Время отгрузки",
            "Размер",
            "Цвет",
            "aID",
            "Материал",
            "Батарейки",
            "Упаковка",
            "Вес (брутто)",
        ];
        */
        /*
                0 "Артикул",
                1 "Основная категория товара",
                2 "Подраздел категории товара",
                3 "Наименование",
                4 "Описание",
                5 "Производитель",
                6 "Артикул производителя",
                7 "Цена (Розница)",
                8 "Цена (Опт)",
                9 "Можно купить",
                10 "На складе",
                11 "Время отгрузки",
                12 "Размер",
                13 "Цвет",
                14 "aID",
                15 "Материал",
                16 "Батарейки",
                17 "Упаковка",
                18 "Вес (брутто)",
                19 "Фотография маленькая до 150*150",
                20 "Фотография 1",
                21 "Фотография 2",
                22 "Фотография 3",
                23 "Фотография 4",
                24 "Фотография 5",
                25 "Штрихкод",
         */

        $slug = $this->slugHelper($productData[3]);
        if (isset($this->products[$slug])) {
            $slug = mb_substr($slug, 0, 66) . '-' . uniqid();
        }

        // добавление товара
        if ($model = Product::find()->where(['name' => $productData[3]])->one()) {
            $lstId = $model->id;
        } else {
            $model = new Product();
            $lstId = 0;
        }

        $model->parent_id = 0;
        $model->measure_id = 1;
        $model->currency_id = 1;
        $model->main_category_id = $categoryId;
        $model->name = $productData[3];
        $model->title = $productData[3];
        $model->breadcrumbs_label = $productData[3];
        $model->h1 = $productData[3];
        $model->slug = $this->slugHelper($productData[3]);
        $model->announce = Helper::trimPlain($productData[4]);
        $model->content = $productData[4];
        $model->price = $productData[7];
        $model->old_price = $productData[7] * 1.15;
        $model->sku = $productData[25];
        $model->save();


        if ($lstId == 0) {
            $productId = Yii::$app->db->getLastInsertID();
        } else {
            $productId = $lstId;
        }
        $this->products[$slug] = $productId;

        if ($model = ProductCategory::find()
            ->where(['category_id' => $categoryId])
            ->andWhere(['object_model_id' => $productId])
            ->one()) {
            $lstId = $model->id;
        } else {
            $model = new ProductCategory();
            $lstId = 0;
        }

        $model->category_id = $categoryId;
        $model->object_model_id = $productId;
        $model->save();

        if ($lstId == 0) {
            $categoryId = Yii::$app->db->getLastInsertID();
        } else {
            $categoryId = $lstId;
        }

/*
        // properties
        if (isset($productData[5])) {
            $this->saveStatic($productId, 'vendor', $productData[5]);
        }


        if ($productData[5] !== '') {
            $product['params'][] = array('name' => 'Производитель', 'value' => $productData[5]);
        }
        if ($productData[6] !== '') {
            $product['params'][] = array('name' => 'Артикул производителя', 'value' => $productData[6]);
        }
        if ($productData[7] !== '') {
            $product['params'][] = array('name' => 'Цена', 'value' => $productData[7]);
        }
        if ($productData[9] !== '') {
            $product['params'][] = array('name' => 'Можно купить', 'value' => $productData[9]);
        }
        if ($productData[10] !== '') {
            $product['params'][] = array('name' => 'На складе', 'value' => $productData[10]);
        }
        if ($productData[11] !== '') {
            $product['params'][] = array('name' => 'Время отгрузки', 'value' => $productData[11]);
        }
        if ($productData[12] !== '') {
            $product['params'][] = array('name' => 'Размер', 'value' => $productData[12]);
        }
        if ($productData[13] !== '') {
            $product['params'][] = array('name' => 'Цвет', 'value' => $productData[13]);
        }
        if ($productData[14] !== '') {
            $product['params'][] = array('name' => 'aID', 'value' => $productData[14]);
        }
        if ($productData[15] !== '') {
            $product['params'][] = array('name' => 'Материал', 'value' => $productData[15]);
        }
        if ($productData[16] !== '') {
            $product['params'][] = array('name' => 'Батарейки', 'value' => $productData[16]);
        }
        if ($productData[17] !== '') {
            $product['params'][] = array('name' => 'Упаковка', 'value' => $productData[17]);
        }
        if ($productData[18] !== '') {
            $product['params'][] = array('name' => 'Вес (брутто)', 'value' => $productData[18]);
        }

        if ($model = ObjectPropertyGroup::find()
            ->where(['object_id' => $productObject->id])
            ->andwhere(['object_model_id' => $productId])
            ->andwhere(['property_group_id' => $commonGroupId])
            ->one()) {
        } else {
            $model = new ObjectPropertyGroup();
        }
        $model->object_id = $productObject->id;
        $model->object_model_id = $productId;
        $model->property_group_id = $commonGroupId;
        $model->save();


        foreach ($product['params'] as $property) {

            // группа свойств
            if ($model = PropertyGroup::find()->where(['name' => $property['name']])->one()) {
                $lstId = $model->id;
            } else {
                $model = new PropertyGroup();
                $lstId = 0;
            }
            $model->object_id = $productObject->id;
            $model->name = $property['name'];
            $model->save();

            if ($lstId == 0) {
                $groupId = Yii::$app->db->getLastInsertID();
            } else {
                $groupId = $lstId;
            }

            $property['name'] = trim($property['name'], '/ ');
            if (in_array($property['name'], $staticProperties)) {
                $key = $this->getKey($property['name']);


                if (!isset($this->properties[$key])) {

                    if ($model = Property::find()
                        ->where(['name' => $property['name']])
                        ->one()) {
                        $lstId = $model->id;
                    } else {
                        $model = new Property();
                        $lstId = 0;
                    }

                    $model->property_group_id = $groupId;
                    $model->name = $property['name'];
                    $model->key = $key;
                    $model->property_handler_id = ($this->selectHandlerId != null) ? $this->selectHandlerId : 0;
                    $model->handler_additional_params = '{}';
                    $model->has_static_values = 1;
                    $model->has_slugs_in_values = 1;
                    $model->save();

                    if ($lstId == 0) {
                        $this->properties[$key] = Yii::$app->db->getLastInsertID();
                    } else {
                        $this->properties[$key] = $lstId;
                    }

                }
                $this->saveStatic(
                    $productId,
                    $this->getKey($property['name']),
                    str_replace($property['name'] . ': ', '', $property['value'])
                );
            } else {
                $this->saveEav(
                    $productId,
                    $groupId,
                    $property['name'],
                    str_replace($property['name'] . ': ', '', $property['value'])
                );
            }
        }
*/
    }


    /*
     * записываем категории
     */
    private function saveCategory($name, $parent_id, $sort_order)
    {
        // проверим наличие группы по имени
        if ($model = Category::find()->where(['name' => $name])->one()) {
            $lstId = $model->id;
        } else {
            $model = new Category();
            $lstId = 1;
        }
        $model->category_group_id = 1;
        $model->parent_id = $parent_id;
        $model->name = $name;
        $model->title = $name;
        $model->h1 = $name;
        $model->meta_description = $name;
        $model->breadcrumbs_label = $name;
        $model->slug = $this->slugHelper($name);
        $model->slug_compiled = $this->slugHelper($name);
        $model->slug_absolute = 0;
        $model->sort_order = $sort_order;
        $model->active = 1;
        $model->save();

        if ($lstId == 0) {
            return Yii::$app->db->getLastInsertID();
        } else {
            return $lstId;
        }
    }

    private function slugHelper($name)
    {
        return str_replace('-', '_', Helper::createSlug($name));
    }


    protected function getKey($name, $length = 20, $delimiter = '_')
    {
        if ($delimiter == '_') {
            $name = str_replace('-', '_', Helper::createSlug($name));
        }
        return mb_strlen($name) > $length
            ? mb_substr($name, 0, $length - 5) . $delimiter . mb_substr(md5($name), 0, 4)
            : $name;
    }

    protected function saveEav($id, $groupId, $name, $value)
    {
        $key = $this->getKey($name);
        if (!isset($this->properties[$key])) {
            if ($model = Property::find()->where(['property_group_id' => $groupId])->one()) {
                $lstId = $model->id;
            } else {
                $model = new Property();
                $lstId = 0;
            }

            $model->property_group_id = $groupId;
            $model->name = $name;
            $model->key = $key;
            $model->property_handler_id = ($this->selectHandlerId != null) ? $this->selectHandlerId : 0;
            $model->handler_additional_params = '{}';
            $model->has_static_values = 1;
            $model->has_slugs_in_values = 0;
            $model->save();

            if ($lstId == 0) {
                $this->properties[$key] = Yii::$app->db->getLastInsertID();
            } else {
                $this->properties[$key] = $lstId;
            }
        }

        if ($model = ProductEav::find()
            ->where(['object_model_id' => $id])
            ->andwhere(['property_group_id' => $groupId])
            ->one()) {
        } else {
            $model = new ProductEav();
        }
        $model->object_model_id = $id;
        $model->property_group_id = $groupId;
        $model->key = $key;
        $model->value = $value;
        $model->save();
    }

    protected function saveStatic($id, $key, $value)
    {
        if (!isset($this->values[$value])) {
            $value = trim($value, '/ ');
            if ($model = PropertyStaticValues::find()
                ->where(['property_id' => BaseObject::getForClass(Product::className())->id])
                ->andwhere(['name' => $id])
                ->one()) {
                $lstId = $model->id;
            } else {
                $model = new PropertyStaticValues();
                $lstId = 0;
            }
            $model->property_id = $this->properties[$key];
            $model->name = $value;
            $model->value = $value;
            $model->slug = $this->slugHelper($value);
            $model->save();

            if ($lstId == 0) {
                $this->values[$value] = Yii::$app->db->getLastInsertID();
            } else {
                $this->values[$value] = $lstId;
            }
        }
        if (ObjectStaticValues::find()
            ->where(['object_id' => BaseObject::getForClass(Product::className())->id])
            ->andwhere(['object_model_id' => $id])
            ->andwhere(['property_static_value_id' => $this->values[$value]])
            ->one()) {
        } else {
            $model = new ObjectStaticValues();
            $model->object_id = BaseObject::getForClass(Product::className())->id;
            $model->object_model_id = $id;
            $model->property_static_value_id = $this->values[$value];
            $model->save();
        }

        return true;
    }
}
