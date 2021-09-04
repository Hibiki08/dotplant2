<?php

use yii\db\Migration;

/**
 * Class m201104_174150_add_domain_default_field
 */
class m201104_174150_add_domain_default_field extends Migration
{
    const TABLE = '{{%subdomain}}';

    public function up()
    {
        $this->addColumn(self::TABLE, 'default', $this->boolean()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn(self::TABLE, 'default');
    }
}
