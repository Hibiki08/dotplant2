<?php

use yii\db\Migration;

/**
 * Class m201203_084956_fix_decimal_columns
 */
class m201203_084956_fix_decimal_columns extends Migration
{
    CONST PRODUCT_TABLE = '{{%product}}';
    CONST IMP_TABLE = '{{%csv_import}}';

    public function safeUp() {

        $this->alterColumn(self::IMP_TABLE, 'baseRetailPrice', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'baseWholePrice', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'brutto', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'lenght', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'diameter', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'retailPrice', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'wholePrice', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'discount', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'brutto_length', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'brutto_width', $this->decimal(10,2));
        $this->alterColumn(self::IMP_TABLE, 'brutto_height', $this->decimal(10,2));

        
        $this->alterColumn(self::PRODUCT_TABLE, 'brutto_length', $this->decimal(10,2));
        $this->alterColumn(self::PRODUCT_TABLE, 'brutto_width',  $this->decimal(10,2));
        $this->alterColumn(self::PRODUCT_TABLE, 'brutto_height', $this->decimal(10,2));
        $this->alterColumn(self::PRODUCT_TABLE, 'brutto', $this->decimal(10,2));
    }

    public function safeDown() {
        
        
        $this->alterColumn('user', 'baseRetailPrice', $this->decimal());
        $this->alterColumn('user', 'baseWholePrice', $this->decimal());
        $this->alterColumn('user', 'brutto', $this->decimal());
        $this->alterColumn('user', 'lenght', $this->decimal());
        $this->alterColumn('user', 'diameter', $this->decimal());
        $this->alterColumn('user', 'retailPrice', $this->decimal());
        $this->alterColumn('user', 'wholePrice', $this->decimal());
        $this->alterColumn('user', 'discount', $this->decimal());
        $this->alterColumn('user', 'brutto_length', $this->decimal());
        $this->alterColumn('user', 'brutto_width', $this->decimal());
        $this->alterColumn('user', 'brutto_height', $this->decimal());

        $this->alterColumn(self::PRODUCT_TABLE, 'brutto_length', $this->decimal());
        $this->alterColumn(self::PRODUCT_TABLE, 'brutto_width',  $this->decimal());
        $this->alterColumn(self::PRODUCT_TABLE, 'brutto_height', $this->decimal());
        $this->alterColumn(self::PRODUCT_TABLE, 'brutto', $this->decimal());
    }
}
