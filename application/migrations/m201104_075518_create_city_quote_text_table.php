<?php

use yii\db\Migration;

/**
 * Handles the creation of table `city_quote_text`.
 */
class m201104_075518_create_city_quote_text_table extends Migration
{
    CONST TABLE = '{{%city_quote_text}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey()->unsigned(),
            'city_id' => $this->integer()->notNull(),
            'text' => $this->string(10000)->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'FK_city_id_quote',
            self::TABLE,
            'city_id',
            '{{%city}}',
            'id',
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
