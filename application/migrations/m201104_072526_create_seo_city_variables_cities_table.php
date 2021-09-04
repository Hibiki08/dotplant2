<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seo_city_variables_cities`.
 */
class m201104_072526_create_seo_city_variables_cities_table extends Migration
{
    CONST TABLE = '{{%seo_city_variables_cities}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'seo_variable_id' => $this->integer()->notNull()->unsigned(),
            'city_id' => $this->integer()->notNull(),
            'seo_word' => $this->string(1024)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('', self::TABLE, ['seo_variable_id', 'city_id']);

        $this->addForeignKey(
            'FK_city_id',
            self::TABLE,
            'city_id',
            '{{%city}}',
            'id',
            'CASCADE' 
        );
        
        $this->addForeignKey(
            'FK_seo_variable_id',
            self::TABLE,
            'seo_variable_id',
            '{{%seo_city_variables}}',
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
