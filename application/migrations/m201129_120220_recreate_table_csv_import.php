<?php

use yii\db\Migration;

/**
 * Class m201129_120220_recreate_table_csv_import
 */
class m201129_120220_recreate_table_csv_import extends Migration
{
    CONST TABLE = '{{%csv_import}}';
    CONST tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

    public function safeUp()
    {
        $this->dropTable(self::TABLE);

        $this->createTable(self::TABLE, [
            'prodID' => $this->integer()->notNull(),
            'aID' => $this->integer()->notNull(),
            'barcode' => $this->string(255)->notNull(),
            'prodName' => $this->string(255)->notNull(),
            'vendorCode' => $this->string(255),
            'vendor' => $this->string(255),
            'vendorID' => $this->integer(),
            'vendorCountry' => $this->string(255),
            'prodCountry' => $this->string(255),
            'baseRetailPrice' => $this->decimal(),
            'baseWholePrice' => $this->decimal(),
            'stock' => $this->integer(),
            'shippingDate' => $this->string(255),
            'description' => $this->text(),
            'brutto' => $this->decimal(),
            'batteries' => $this->string(255),
            'pack' => $this->string(255),
            'material' => $this->string(255),
            'lenght' => $this->decimal(),
            'diameter' => $this->decimal(),
            'collection' => $this->string(255),
            'images' => $this->text(),
            'category' => $this->string(255)->notNull(),
            'subCategory' => $this->string(255)->notNull(),
            'categoryId' => $this->integer(),
            'subcategoryId' => $this->integer(),
            'color' => $this->string(255),
            'size' => $this->string(255),
            'novelties' => $this->integer(1),
            'superSale' => $this->integer(1),
            'bestseller' => $this->integer(1),
            'retailPrice' => $this->decimal(),
            'wholePrice' => $this->decimal(),
            'discount' => $this->decimal(),
            'prodUrl' => $this->string(255),
            'function' => $this->string(255),
            'addfunction' => $this->string(255),
            'vibration' => $this->integer(1),
            'volume' => $this->string(255),
            'modelYear' => $this->integer(),
            'img_status' => $this->integer(1),
            'ready_to_go' => $this->integer(1),
            'stopPromo' => $this->integer(1),
            'brutto_length' => $this->decimal(),
            'brutto_width' => $this->decimal(),
            'brutto_height' => $this->decimal(),
            'imported' => $this->integer(1)->notNull()->defaultValue(0),
            'importErr' => $this->text(),
        ], self::tableOptions);

        $this->createIndex('csvimp-1',self::TABLE,['prodID']);
        $this->createIndex('csvimp-2',self::TABLE,['category']);
        $this->createIndex('csvimp-3',self::TABLE,['subcategory']);
        $this->createIndex('csvimp-4',self::TABLE,['prodName']);
        $this->createIndex('csvimp-5',self::TABLE,['barcode']);
        $this->createIndex('csvimp-6',self::TABLE,['imported']);
        $this->createIndex('csvimp-aId',self::TABLE,['aId']);
        $this->createIndex('csvimp-categoryId',self::TABLE,['categoryId']);
        $this->createIndex('csvimp-subcategoryId',self::TABLE,['subcategoryId']);
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE);

        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'articul' => $this->integer()->notNull()->unsigned(),
            'category' => $this->string(255)->notNull(),
            'categoryId' => $this->integer(),
            'subcategory' => $this->string(255)->notNull(),
            'subcategoryId' => $this->integer(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'vendor' => $this->string(1024)->notNull(),
            'vendorArticul' => $this->string(255)->notNull(),
            'price' => $this->decimal()->notNull(),
            'priceOpt' => $this->decimal()->notNull(),
            'canBuy' => $this->integer(1)->notNull(),
            'placeCnt' => $this->integer()->notNull(),
            'ship' => $this->integer(),
            'size' => $this->string(255),
            'color' => $this->string(255),
            'aId' => $this->integer(),
            'material' => $this->string(1024),
            'power' => $this->string(1024),
            'pack' => $this->string(1024),
            'weight' => $this->float(),
            'smallphoto' => $this->string(1024),
            'photo1' => $this->string(1024),
            'photo2' => $this->string(1024),
            'photo3' => $this->string(1024),
            'photo4' => $this->string(1024),
            'photo5' => $this->string(1024),
            'barcode' => $this->float(),
            'imported' => $this->integer(1)->notNull()->defaultValue(0),
            'importErr' => $this->text(),
        ], self::tableOptions);

        $this->createIndex('csvimp-1',self::TABLE,['articul']);
        $this->createIndex('csvimp-2',self::TABLE,['category']);
        $this->createIndex('csvimp-3',self::TABLE,['subcategory']);
        $this->createIndex('csvimp-4',self::TABLE,['name']);
        $this->createIndex('csvimp-5',self::TABLE,['barcode']);
        $this->createIndex('csvimp-6',self::TABLE,['imported']);
        $this->createIndex('csvimp-aId',self::TABLE,['aId']);
        $this->createIndex('csvimp-categoryId',self::TABLE,['categoryId']);
        $this->createIndex('csvimp-subcategoryId',self::TABLE,['subcategoryId']);
    }
}

/*
prodID;aID;Barcode;ProdName;VendorCode;Vendor;VendorID;VendorCountry;ProdCountry;BaseRetailPrice;BaseWholePrice;Stock;ShippingDate;Description;Brutto;Batteries;Pack;Material;Lenght;Diameter;Collection;Images;Category;SubCategory;Color;Size;Novelties;SuperSale;Bestseller;RetailPrice;WholePrice;Discount;prodUrl;function;addfunction;vibration;volume;ModelYear;img_status;ready_to_go;StopPromo;Brutto_length;Brutto_width;Brutto_height
*/