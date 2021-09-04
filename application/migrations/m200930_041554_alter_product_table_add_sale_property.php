<?php

use yii\db\Migration;

/**
 * Class m200930_041554_alter_product_table_add_sale_property
 */
class m200930_041554_alter_product_table_add_sale_property extends Migration
{
    const TABLE = '{{%product}}';

    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'sale', $this->integer(1)->defaultValue(0));
        $this->addColumn(self::TABLE, 'sale_start_date', 'DATETIME DEFAULT NULL');
        $this->addColumn(self::TABLE, 'sale_end_date', 'DATETIME DEFAULT NULL');

        $this->createIndex('indx_product_sale', self::TABLE, ['sale']);
        $this->createIndex('indx_product_sale_st', self::TABLE, ['sale_start_date']);
        $this->createIndex('indx_product_sale_end', self::TABLE, ['sale_end_date']);
        $this->createIndex('indx_product_sale_dates', self::TABLE, ['sale_start_date', 'sale_end_date']);
    }


    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'sale');
        $this->dropColumn(self::TABLE, 'sale_start_date');
        $this->dropColumn(self::TABLE, 'sale_end_date');
    }
}
