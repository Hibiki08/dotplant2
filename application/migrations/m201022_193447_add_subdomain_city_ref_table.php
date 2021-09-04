<?php

use yii\db\Migration;

/**
 * Class m201022_193447_add_subdomain_city_ref_table
 */
class m201022_193447_add_subdomain_city_ref_table extends Migration
{
    const TABLE = '{{%subdomain_city_ref}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'subdomain_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk_subdomain_city_ref', self::TABLE, [
            'subdomain_id',
            'city_id',
        ]);

        $this->addForeignKey(
            'fk_scref_subdomain_id',
            self::TABLE,
            'subdomain_id',
            '{{%subdomain}}',
            'id',
            null,
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_scref_city_id',
            self::TABLE,
            'city_id',
            '{{%city}}',
            'id',
            null,
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
