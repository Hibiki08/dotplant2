<?php

use yii\db\Migration;

/**
 * Class m201201_153325_alter_order_delivery_information_table
 */
class m201201_153325_alter_order_delivery_information_table extends Migration
{
    CONST TABLE = '{{%order_delivery_information}}';

    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'deliveryInformationId', $this->integer());
    }


    public function safeDown() {
        $this->dropColumn(self::TABLE, 'deliveryInformationId');
    }
}

