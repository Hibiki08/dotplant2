<?php

use yii\db\Migration;

/**
 * Class m200912_102423_add_user_addresses_tables
 */
class m200912_102423_add_user_address_table extends Migration
{
    const USER_ADDRESS_TABLE = '{{%user_address}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::USER_ADDRESS_TABLE, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unsigned(),
            'default' => $this->tinyInteger()->defaultValue(0)->notNull(),
            'name' => $this->string()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'zip_code' => $this->integer()->notNull(),
            'address' => $this->string()->notNull(),
        ]);
        $this->addForeignKey(
            'user_address_user_id_fk',
            self::USER_ADDRESS_TABLE,
            'user_id',
            '{{%user}}',
            'id'
        );
        $this->addForeignKey(
            'user_address_country_id_fk',
            self::USER_ADDRESS_TABLE,
            'country_id',
            '{{%country}}',
            'id'
        );
        $this->addForeignKey(
            'user_address_city_id_fk',
            self::USER_ADDRESS_TABLE,
            'city_id',
            '{{%city}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::USER_ADDRESS_TABLE);
    }
}
