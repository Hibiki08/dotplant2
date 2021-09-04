<?php

namespace app\modules\import\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\db\Expression;
use yii\helpers\FileHelper;
use ruskid\csvimporter\CSVImporter;
use ruskid\csvimporter\CSVReader;
use ruskid\csvimporter\MultipleImportStrategy;
use app\modules\shop\models\Category;
use app\modules\shop\models\Product;
use app\modules\shop\models\ProductCategory;
use app\modules\shop\models\ProductEav;
use app\components\Helper;
use yii\helpers\Json;
use app\models\PropertyGroup;
use app\models\Property;
use app\models\ObjectPropertyGroup;
use app\models\PropertyStaticValues;
use app\models\ObjectStaticValues;
use app\modules\image\models\Image;

class ImportRowsService extends Model
{
    public $table = '{{%csv_import}}';
    public $sort = 0;
    public $productObjectId = 3;

    public $oldPriceOption = 1;
    public $priceOption = 1;
    public $oldPriceCoeff = 1.15;
    public $priceCoeff = 1;
    
    public function getOldPrice($oldPriceOption) {
        return ImportForm::getOptionsSets()[$oldPriceOption];
    }

    public function getPrice($priceOption) {
        return ImportForm::getOptionsSets()[$priceOption];
    }

    public function getTotal() {
        $total = (new Query)
            ->from($this->table)
            ->count();

        return $total;
    }

    public function getImported() {
        return (new Query)
            ->from($this->table)
            ->where(['imported' => 1,])
            ->count();
    }

    public function importCategories() {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $categoryNames = (new Query)->select('category')->distinct()->from($this->table)->column();

            foreach($categoryNames as $name) {
                $categoryId = $this->getCategory($name, 1, $this->sort++);
                Yii::$app->db->createCommand()
                    ->update($this->table, ['categoryId' => $categoryId], ['category' => $name])
                    ->execute();

                $subcategoryNames = (new Query)
                    ->select('subcategory')
                    ->distinct()
                    ->from($this->table)
                    ->where(['categoryId' => $categoryId ])
                    ->column();

                foreach($subcategoryNames as $subname) {
                    $subcategoryId = $this->getCategory($subname, $categoryId, $this->sort++);

                    Yii::$app->db->createCommand()
                        ->update($this->table, ['subcategoryId' => $subcategoryId], ['subcategory' => $subname])
                        ->execute();
                }
            }

            Yii::$app->db->createCommand()
                ->update($this->table, ['imported' => 0])
                ->execute();
            
            Product::updateAll(['status' => 2]);

            $this->categoryImages();

            Yii::$app->session->addFlash('success', "Список категорий актуализирован");
            $transaction->commit();
            $result =  true;

        } catch (\Throwable $th) {
            Yii::$app->session->addFlash('error', 'Произошла ошибка при загрузке файла');
            Yii::error('Произошла ошибка при загрузке файла');
            Yii::error($th);
            $transaction->rollback();
            $result = false;
        }
        return $result;
        
    }

    public function categoryImages()
    {
        FileHelper::createDirectory(Yii::getAlias('@webroot/files/category/'));

        $catIds = Yii::$app->db->createCommand('SELECT distinct categoryId FROM csv_import')
            ->queryColumn();

        foreach ($catIds as $id) {
            try {
                $product = Yii::$app->db->createCommand('
                        SELECT images
                        FROM csv_import
                        WHERE categoryId = ' . $id . '
                        and images is not null
                        ORDER BY RAND() limit 1')
                    ->queryOne();

                copy(
                    $this->getFirstImage($product['images']),
                    Yii::getAlias('@webroot/files/category/' . $id . '.jpg')
                );
            } catch (\Throwable $th) {
                Yii::$app->session->addFlash('error', 'Ошибка скачивания рисунка категории');
                Yii::error('Ошибка скачивания рисунка категории');
                Yii::error($th);
            }
        }

        $this->categorySubGroupImages();
    }

    public function categorySubGroupImages()
    {
        $catIds = Yii::$app->db->createCommand('SELECT distinct subcategoryId FROM csv_import')
            ->queryColumn();

        foreach ($catIds as $id) {
            try {
                $product = Yii::$app->db->createCommand('
                        SELECT images
                        FROM csv_import
                        WHERE subcategoryId = ' . $id . '
                        ORDER BY RAND() limit 1')
                    ->queryOne();

                copy(
                    $this->getFirstImage($product['images']),
                    Yii::getAlias('@webroot/files/category/' . $id . '.jpg')
                );
            } catch (\Throwable $th) {
                Yii::$app->session->addFlash('error', 'Ошибка скачивания рисунка саб-категории');
                Yii::error('Ошибка скачивания рисунка саб-категории');
                Yii::error($th);
            }
        }
    }

    public function getFirstImage($images) {
        $images = \explode(' ', $images);
        return $images[0];
    }

    public function getPropertyGroup() {
        $group = PropertyGroup::findOne(['name' => 'Общая группа свойств']);

        if(!$group) {
            $group = new PropertyGroup([
                'object_id' => 1,
                'name' => 'Общая группа свойств',
            ]);

            if(!$group->save()) {
                Yii::error($group->errors);
            }
        }

        return $group->id;
    }

    public function getProperty($gruopId, $key, $name) {
        $property = Property::findOne([
            'property_group_id' => $gruopId,
            'key' => $key,
        ]);

        if(!$property) {
            $property = new Property([
                'property_group_id' => $gruopId,
                'name' => $name,
                'key' => $key,
                'property_handler_id' => 2,
                'handler_additional_params' => '{}',
                'has_static_values' => 1,
                'has_slugs_in_values' => 1,
            ]);

            if(!$property->save()) {
                Yii::error($property->errors);
                throw Exception('Ошибка сохранения свойства');
            }
        }

        return $property->id;
    }

    public function getNumberProperty($gruopId, $key, $name) {
        $property = Property::findOne([
            'property_group_id' => $gruopId,
            'key' => $key,
        ]);

        if(!$property) {
            $property = new Property([
                'property_group_id' => $gruopId,
                'name' => $name,
                'key' => $key,
                'value_type' => 'NUMBER',
                'property_handler_id' => 1,
                'handler_additional_params' => '{}',
                'has_static_values' => 0,
                'has_slugs_in_values' => 0,
                'is_eav' => 1,
            ]);

            if(!$property->save()) {
                Yii::error($property->errors);
                throw Exception('Ошибка сохранения свойства');
            }
        }

        return $property->id;
    }

    public function getCategory($name, $parent, $sort) {
        $category = Category::findOne(['name' => $name]);

        $categoryData = [
            'category_group_id' => 1,
            'parent_id' => $parent,
            'name' => $name,
            'title' => $name,
            'h1' => $name,
            'meta_description' => $name,
            'breadcrumbs_label' => $name,
            'slug' => $this->slugHelper($name),
            'slug_compiled' => $this->slugHelper($name),
            'slug_absolute' => 0,
            'sort_order' => $sort,
            'active' => 1,
        ];

        if(!$category) {
            $category = new Category($categoryData);
        } else {
            $category->setAttributes($categoryData);
        }

        if(!$category->save()) {
            Yii::error($category->errors);
        }
        
        return $category->id;
    }

    public function importProducts($limit = 50) {
        $transaction = Yii::$app->db->beginTransaction();
        $logProductData = [];
        
        try {
            $commonGroupId = $this->getPropertyGroup();

            $vendorPropertyId = $this->getProperty($commonGroupId, 'vendor', 'Производитель');
            $sizePropertyId = $this->getProperty($commonGroupId, 'size', 'Размер');
            $colorPropertyId = $this->getProperty($commonGroupId, 'color', 'Цвет');
            $materialPropertyId = $this->getProperty($commonGroupId, 'material', 'Материал');
            $collectionPropertyId = $this->getProperty($commonGroupId, 'collection', 'Коллекция');
            $batteriesPropertyId = $this->getProperty($commonGroupId, 'batteries', 'Батарейки');
            $packPropertyId = $this->getProperty($commonGroupId, 'pack', 'Упаковка');

            $lengthPropertyId = $this->getNumberProperty($commonGroupId, 'length', 'Длина, см');
            $diameterPropertyId = $this->getNumberProperty($commonGroupId, 'diameter', 'Диаметр, см');


            $csvRows = (new Query)
                ->from($this->table)
                ->where(['imported' => 0,])
                ->limit($limit)
                ->indexBy('aID')
                ->orderBy('aID');

            

            foreach($csvRows->batch() as  $rows) {
                foreach($rows as $aID => $row) {
                    $product = Product::findOne(['aId' => $aID]);
                    $category= Category::findOne($row['subcategoryId']);

                    $price = ($row[$this->getPrice($category->price)] + 150) * $category->priceK;
                    $oldPrice = $row[$this->getOldPrice($category->oldPrice)] * $category->oldPriceK;
                    
                    $productData = [
                        'parent_id' => 0,
                        'measure_id' => 1,
                        'currency_id' => 1,
                        'main_category_id' => (int) $row['subcategoryId'],
                        'name' => $row['prodName'],
                        'title' => $row['prodName'],
                        'breadcrumbs_label' => $row['prodName'],
                        'h1' => $row['prodName'],
                        'announce' => $this->trimPlain($row['description']),
                        'content' => $row['description'],
                        'price' => round($price, 1),
                        'old_price' => round(( $price >= $oldPrice ? null : $oldPrice), 1),
                        'sku' => $row['prodID'],
                        'unlimited_count' => ($row['stock'] ? 1 : 0),
                        //'active' => $row['canBuy'],
                        'status' => 0,
                        'aId' => $aID,
                    ];

                    if(!empty($row['brutto'])) {
                        $productData['brutto'] = $row['brutto'];
                    }

                    if(!empty($row['brutto_length'])) {
                        $productData['brutto_length'] = $row['brutto_length'];
                    }

                    if(!empty($row['brutto_width'])) {
                        $productData['brutto_width'] = $row['brutto_width'];
                    }

                    if(!empty($row['brutto_height'])) {
                        $productData['brutto_height'] = $row['brutto_height'];
                    }

                    if(!$product) {
                        $productData['slug'] = substr(Helper::createSlug($row['prodName']), 0, 80);
                        $product = new Product($productData);
                    } else {
                        $product->setAttributes($productData);
                    }

                    $product->validate();
                    if(isset($product->errors['slug'])) {
                        $slug = (substr($product->slug, 0, 80 - strlen($aID) - 1) . '-' . $aID);
                        $product->slug = $slug;
                        $product->validate();
                    }

                    $newAttr = $product->dirtyAttributes;
                    $oldAttr = $product->oldAttributes;

                    $flag = empty($product->dirtyAttributes);

                    $logData = [];
                    if(!$flag) {
                        foreach ($newAttr as $name => $value) {
                            if($name != 'status' && $value != ($oldAttr[$name] ?? null)) {
                                $logData[] = [
                                    'productId' => $product->id,
                                    'attribute' => $name,
                                    'newvalue' => $value,
                                    'oldvalue' => $oldAttr[$name] ?? null,
                                ];
                            }
                        }
                    }
                    
                    if(!$flag) {
                        $flag = $product->save();
                    }

                    foreach($logData as $i => $data) {
                        $data['productId'] = $product->id;
                        $logProductData[] = $data;
                    }

                    if(!$flag) {
                        Yii::error($product->errors);
                        Yii::$app->db->createCommand()
                            ->update($this->table, 
                                ['imported' => -1, 'importErr' => Json::encode($product->errors, true),],
                                ['aID' => $aID]
                            )
                            ->execute();
                    } else {
                        Yii::$app->db->createCommand()
                            ->update($this->table, 
                                ['imported' => 1, 'importErr' => null,],
                                ['aID' => $aID]
                            )
                            ->execute();
                        
                        $producCategoryRootData = ['category_id' => 1,'object_model_id' => $product->id,];
                        $producCategoryRoot = ProductCategory::findOne($producCategoryRootData);
                        if(!$producCategoryRoot) {
                            $producCategoryRoot = new ProductCategory($producCategoryRootData);

                            if(!$producCategoryRoot->save()) {
                                Yii::error($producCategoryRoot->errors);
                            }
                        }

                        $producCategoryMainCatData = ['category_id' => $row['categoryId'],'object_model_id' => $product->id,];
                        $producCategoryMainCat = ProductCategory::findOne($producCategoryMainCatData);
                        if(!$producCategoryMainCat) {
                            $producCategoryMainCat = new ProductCategory($producCategoryMainCatData);

                            if(!$producCategoryMainCat->save()) {
                                Yii::error($producCategoryMainCat->errors);
                            }
                        }

                        $producCategorySubCatData = ['category_id' => $row['subcategoryId'],'object_model_id' => $product->id,];
                        $producCategorySubCat = ProductCategory::findOne($producCategorySubCatData);
                        if(!$producCategorySubCat) {
                            $producCategorySubCat = new ProductCategory($producCategorySubCatData);

                            if(!$producCategorySubCat->save()) {
                                Yii::error($producCategorySubCat->errors);
                            }
                        }

                        $objPropGroupData = [
                            'object_id' => $this->productObjectId,
                            'object_model_id' => $product->id,
                            'property_group_id' => $commonGroupId,
                        ];
                        $objPropGroup = ObjectPropertyGroup::findOne($objPropGroupData);
                        if(!$objPropGroup) {
                            $objPropGroup = new ObjectPropertyGroup($objPropGroupData);

                            if(!$objPropGroup->save()) {
                                Yii::error($objPropGroup->errors);
                            }
                        }
                        

                        $this->setProperty($colorPropertyId, $product->id, $row['color']);
                        
                        $this->setProperty($sizePropertyId, $product->id, $row['size']);
                        
                        $this->setProperty($vendorPropertyId, $product->id, $row['vendor']);
                        
                        $this->setProperty($materialPropertyId, $product->id, $row['material']);
                        
                        $this->setProperty($collectionPropertyId, $product->id, $row['collection']);

                        $this->setProperty($batteriesPropertyId, $product->id, $row['batteries']);
                    
                        $this->setProperty($packPropertyId, $product->id, $row['pack']);
                    

                        $this->setNumberProperty($commonGroupId, $product->id, 'length', $row['lenght']);
                        
                        $this->setNumberProperty($commonGroupId, $product->id, 'diameter', $row['diameter']);
    
                        /**
                         * Вызывает ошибку
                         */

                        /*
                        $objPropGroupCatData = [
                            'object_id' => $this->productObjectId,
                            'object_model_id' => $product->id,
                            'property_group_id' => $row['subcategoryId'],
                        ];
                        $objPropGroupCat = ObjectPropertyGroup::findOne($objPropGroupCatData);
                        if(!$objPropGroupCat) {
                            $objPropGroupCat = new ObjectPropertyGroup($objPropGroupCatData);

                            if(!$objPropGroupCat->save()) {
                                Yii::error($objPropGroupCat->errors);
                            }
                        }
                        */

                        $this->imagesAdd($product->id, $row);
                    }

                    unset($product);
                }
            }

            Yii::$app->db->createCommand()->batchInsert(
                '{{%product_history}}',
                [
                    'productId',
                    'attribute',
                    'newvalue',
                    'oldvalue',
                ],
                $logProductData
            )->execute();;

            $transaction->commit();

            if($csvRows->count() == 0) {
                Product::updateAll(['status' => 1], ['status' => 2,]);
                Yii::$app->session->addFlash('success', 'Товары успешно импортированы');
                return false;
            }

            return true;
        } catch (\Throwable $th) {
            Yii::$app->session->addFlash('error', 'Произошла ошибка при импорте товаров');
            Yii::error('Произошла ошибка при импорте товаров');
            Yii::error($th);
            $transaction->rollback();
            $result = false;
        }

    }

    public function setProperty($propertyId, $productId, $value) {
        if(!empty($value)) {
            $propertyStaticValue = PropertyStaticValues::findOne([
                'value' => $value,
                'property_id' => $propertyId,
            ]);
    
            if(!$propertyStaticValue) {
                $propertyStaticValue = new PropertyStaticValues([
                    'value' => $value,
                    'name' => $value,
                    'property_id' => $propertyId,
                    'slug' => $this->slugHelper($value),
                ]);
    
                if(!$propertyStaticValue->save()) {
                    Yii::error($propertyStaticValue->errors);
                }
            }
    
            $values = PropertyStaticValues::find()
                ->select('id')
                ->where(['property_id' => $propertyId,]);
    
            $valueData = [
                'object_id' => $this->productObjectId,
                'object_model_id' => $productId,
                'property_static_value_id' => $values,
            ];
    
            $objectValue = ObjectStaticValues::deleteAll($valueData);
    
            $valueData['property_static_value_id'] = $propertyStaticValue->id;
    
            $objectValue = new ObjectStaticValues($valueData);
    
            if(!$objectValue->save()) {
                Yii::error($objectValue->errors);
            }
        }
    }

    public function setNumberProperty($propertyGruopId, $productId, $key, $value) {
        if(!empty($value)) {
            $eavData = [
                'key' => $key,
                'object_model_id' => $productId,
                'property_group_id' => $propertyGruopId,
            ];
            $productEav = ProductEav::findOne($eavData);
    
            if(!$productEav) {
                $productEav = new ProductEav($eavData);
            }
    
            $productEav->value = $value;
    
            if(!$productEav->save()) {
                Yii::error($productEav->errors);
            }
        }
    }

    public function imagesAdd($productId, $row) {
        $images = \explode(' ', $row['images']);

        /*
        if($row[$smallphoto] != '') {
            $smallImage = preg_replace(array('/small_/', '/\.jpg/'), array('', '-180x180.jpg'), $this->urlImage($row[$smallphoto]));
            FileHelper::createDirectory(Yii::getAlias('@webroot/files/thumbnail/'));

            if(!\file_exists($file = (Yii::getAlias('@webroot/files/thumbnail/' . $smallImage))))
            {
                Yii::beginProfile('downloadSmall'); 
                //file_put_contents($file, file_get_contents($row[$smallphoto]));    
                copy($row[$smallphoto], $file);    
                Yii::endProfile('downloadSmall');
            }
        }
        */

        $i = 0;
        foreach($images as $img) {
            $image = $this->urlImage($img);
            $imageModel = Image::findOne(['object_model_id' => $productId, 'filename' => $image,]);
            if($img != '' && $this->checkImageFile($img, $image) && !$imageModel ) {
                $imageData = [
                    'object_id' => $this->productObjectId,
                    'object_model_id' => $productId,
                    'filename' => $image,
                    'image_alt' => $row['prodName'],
                    'sort_order' => $i++,
                    'image_title' => $row['prodName'],
                ];

                Yii::$app->db->createCommand()->insert(Image::tableName(), $imageData)->execute();
            } elseif($imageModel) {
                $this->checkImageFile($img, $image);
            }
        }
    }

    public function checkImageFile($url, $fileName) {
        $result = true;
        if(!\file_exists($file = (Yii::getAlias('@webroot/files/' . $fileName))))
        {
            Yii::beginProfile('download image ' . $url); 
            try {
                file_put_contents($file, file_get_contents($url));    
            } catch (\Throwable $th) {
                $result = false;
                Yii::$app->session->addFlash('error', 'Ошибка скачивания рисунка товара');
                Yii::error('Ошибка скачивания рисунка товара');
                Yii::error($th);
            }
            Yii::endProfile('download image ' . $url);
        } else {
            //Yii::warning($file);
        }
        return $result;
    }

    public function urlImage($url)
    {
        $urlData = explode('/', $url);

        return $urlData[count($urlData)-1];
    }


    public function slugHelper($name)
    {
        return str_replace('-', '_', $this->createSlug($name));
    }

    public function createSlug($source)
    {
        $source = mb_strtolower($source);
        $translateArray = [
            "ый" => "y", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "c", "ч" => "ch" ,"ш" => "sh", "щ" => "sch", "ъ" => "",
            "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
            " " => "-", "." => "", "/" => "-", "_" => "-"
        ];
        $source = preg_replace('#[^a-z0-9\-]#is', '', strtr($source, $translateArray));
        return trim(preg_replace('#-{2,}#is', '-', $source));
    }

    public function trimPlain($text, $length = 150, $dots = '...')
    {
        if (!is_string($text) && empty($text)) {
            return "";
        }
        $length = intval($length);
        $text = trim(strip_tags($text));
        $pos = mb_strrpos(mb_substr($text, 0, $length), ' ');
        $string = mb_substr($text, 0, $pos);
        if (!empty($string)) {
            return $string.$dots;
        } else {
            return "";
        }
    }
}