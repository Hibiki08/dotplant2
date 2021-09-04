<?php

use yii\db\Migration;

/**
 * Class m200927_160807_add_description_to_payment_type_table
 */
class m200927_160807_add_description_to_payment_type_table extends Migration
{
    const TABLE = '{{%payment_type}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(self::TABLE, 'description', $this->string(250));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(self::TABLE, 'description');
    }
}
