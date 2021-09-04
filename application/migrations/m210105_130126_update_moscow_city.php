<?php

use yii\db\Migration;
use app\models\City;

/**
 * Class m210105_130126_update_moscow_city
 */
class m210105_130126_update_moscow_city extends Migration
{

    public function safeUp()
    {
        City::updateAll(['cdek_code' => 44], ['id' => 1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        City::updateAll(['cdek_code' => 61627], ['id' => 1]);
    }

}
