<?php

use yii\db\Migration;

/**
 * Class m201203_051738_alter_category_table
 */
class m201203_051738_alter_category_table extends Migration
{
    CONST TABLE = '{{%category}}';

    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'price', $this->integer());
        $this->addColumn(self::TABLE, 'priceK', $this->decimal(10, 2));
        $this->addColumn(self::TABLE, 'oldPrice', $this->integer());
        $this->addColumn(self::TABLE, 'oldPriceK', $this->decimal(10, 2));
    }


    public function safeDown() {
        $this->dropColumn(self::TABLE, 'price');
        $this->dropColumn(self::TABLE, 'priceK');
        $this->dropColumn(self::TABLE, 'oldPrice');
        $this->dropColumn(self::TABLE, 'oldPriceK');
    }
}