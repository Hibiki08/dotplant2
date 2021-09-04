<?php

use yii\db\Migration;

/**
 * Class m201105_195210_add_parental_case_field_to_city_table
 */
class m201105_195210_add_parental_case_field_to_city_table extends Migration
{
    const TABLE = '{{%city}}';

    public function up()
    {
        $this->addColumn(self::TABLE, 'parental_case', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE, 'parental_case');
    }
}
