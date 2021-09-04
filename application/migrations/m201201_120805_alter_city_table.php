<?php

use yii\db\Migration;

/**
 * Class m201201_120805_alter_city_table
 */
class m201201_120805_alter_city_table extends Migration
{
    CONST TABLE = '{{%city}}';

    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'cdek_code', $this->integer());
    }


    public function safeDown() {
        $this->dropColumn(self::TABLE, 'cdek_code');
    }
}
