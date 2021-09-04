<?php

use yii\db\Migration;

/**
 * Class m201027_190743_add_contacts_table
 */
class m201027_190743_add_contacts_table extends Migration
{
    const TABLE = '{{%contacts}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'phone_number' => $this->string(255),
            'address' => $this->string(255),
            'support_phone_number' => $this->string(255),
            'email' => $this->string(50),
            'city_id' => $this->integer(),
            'subdomain_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_contacts_subdomain_id',
            self::TABLE,
            'subdomain_id',
            '{{%subdomain}}',
            'id',
            null,
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_contacts_city_id',
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
