<?php

use yii\db\Migration;
use yii\db\Schema;


/**
 * Handles the creation of table `csv_import`.
 */
class m201124_070121_create_csv_import_table extends Migration
{
    CONST TABLE = '{{%csv_import}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

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
        ], $tableOptions);

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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}

