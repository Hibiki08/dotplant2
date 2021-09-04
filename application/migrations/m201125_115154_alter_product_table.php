<?php

use yii\db\Migration;

/**
 * Class m201125_115154_alter_product_table
 */
class m201125_115154_alter_product_table extends Migration
{
    CONST TABLE = '{{%product}}';

    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'aId', $this->integer());
        $this->addColumn(self::TABLE, 'status', $this->integer(1)->notNull()->defaultValue(0));
        $this->addColumn(self::TABLE, 'notBox', $this->integer(1)->notNull()->defaultValue(0));
        $this->addColumn(self::TABLE, 'notWeight', $this->integer(1)->notNull()->defaultValue(0));

        $this->createIndex('indx_product_aId', self::TABLE, ['aId']);
        $this->createIndex('indx_product_status', self::TABLE, ['aId']);
        $this->createIndex('indx_product_notbox', self::TABLE, ['notBox']);
        $this->createIndex('indx_product_notweight', self::TABLE, ['notWeight']);
    }


    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'aId');
        $this->dropColumn(self::TABLE, 'status');
        $this->dropColumn(self::TABLE, 'notBox');
        $this->dropColumn(self::TABLE, 'notWeight');
    }
}
