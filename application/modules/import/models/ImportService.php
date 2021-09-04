<?php

namespace app\modules\import\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
use ruskid\csvimporter\CSVImporter;
use ruskid\csvimporter\CSVReader;
use ruskid\csvimporter\MultipleImportStrategy;
use app\modules\shop\models\Category;
use app\modules\shop\models\Product;
use app\modules\shop\models\ProductCategory;

class ImportService extends Model
{
    public function getFilename() {
        return FileHelper::normalizePath(Yii::getAlias('@files/import/data.csv'));
    }

    public function import() {
        $transaction = Yii::$app->db->beginTransaction();
 
        try {
            \Yii::$app
                ->db
                ->createCommand()
                ->delete('{{%csv_import}}')
                ->execute();

            if (!file_exists($this->filename)) {
                throw new Exception(__CLASS__ . ' couldn\'t find the CSV file.');
            }

            $totalCount = 0;
            $count = 0;
            $lines = [];
            if (($fp = fopen($this->filename, 'r')) !== FALSE) {
                while (($line = fgetcsv($fp, 0, ';', '"')) !== FALSE) {
                    if($count <= 500) {
                        if($count > 0) {array_push($lines, $line);}
                    } else {
                        $this->insertRows($lines);
                        $lines = []; //Clear and set rows
                        $count = 0;
                    }
                    $count++;
                    $totalCount++;
                }
            }
            if(!empty($lines)) {
                $this->insertRows($lines);
            }

            Yii::$app->session->addFlash('success', "Загружено $totalCount строк");
            $transaction->commit();
            $result =  $totalCount;

        } catch (\Throwable $th) {
            Yii::$app->session->addFlash('error', 'Произошла ошибка при загрузке файла');
            Yii::error('Произошла ошибка при загрузке файла');
            Yii::error($th);
            $transaction->rollback();
            $result = false;
        }
        return $result;
        
    }

    public function insertRows($lines) {
        Yii::$app->db->createCommand()->batchInsert(
            '{{%csv_import}}',
            [
                'prodID',
                'aID',
                'barcode',
                'prodName',
                'vendorCode',
                'vendor',
                'vendorID',
                'vendorCountry',
                'prodCountry',
                'baseRetailPrice',
                'baseWholePrice',
                'stock',
                'shippingDate',
                'description',
                'brutto',
                'batteries',
                'pack',
                'material',
                'lenght',
                'diameter',
                'collection',
                'images',
                'category',
                'subCategory',
                'color',
                'size',
                'novelties',
                'superSale',
                'bestseller',
                'retailPrice',
                'wholePrice',
                'discount',
                'prodUrl',
                'function',
                'addfunction',
                'vibration',
                'volume',
                'modelYear',
                'img_status',
                'ready_to_go',
                'stopPromo',
                'brutto_length',
                'brutto_width',
                'brutto_height',
            ],
            $lines
        )->execute();
    }

    public static function clearAll() {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Category::deleteAll(['!=', 'id', 1]);
            Product::deleteAll();
            ProductCategory::deleteAll();
            \app\modules\image\models\Image::deleteAll();
            Yii::$app->session->addFlash('success', "Данные успешно удалены");
            $transaction->commit();
        } catch (\Throwable $th) {
            Yii::$app->session->addFlash('error', 'Произошла ошибка при удалении данных');
            Yii::error('Произошла ошибка при удалении данных');
            Yii::error($th);
            $transaction->rollback();
        }
    }
}