<?php

use yii\db\Migration;

/**
 * Class m201201_092151_alter_delivery_information_table
 */
class m201201_092151_alter_delivery_information_table extends Migration
{
    CONST TABLE = '{{%delivery_information}}';

    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'isPickup', $this->integer()->notNull()->defaultValue(0));
    }


    public function safeDown() {
        $this->dropColumn(self::TABLE, 'isPickup');
    }
}
