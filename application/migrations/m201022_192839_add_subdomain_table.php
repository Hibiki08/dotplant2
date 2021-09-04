<?php

use yii\db\Migration;

/**
 * Class m201022_192839_add_subdomain_table
 */
class m201022_192839_add_subdomain_table extends Migration
{
    const TABLE = '{{%subdomain}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'domain_prefix' => $this->string(255),
            'is_stock' => $this->boolean()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
