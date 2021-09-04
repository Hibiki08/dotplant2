<?php

use yii\db\Migration;

/**
 * Class m200921_053207_alter_user_table
 */
class m200921_053207_alter_user_table extends Migration
{
    const TABLE = '{{%user}}';

    public function up()
    {
        $this->addColumn(self::TABLE, 'phone', $this->string(64));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE, 'phone');
    }

}
