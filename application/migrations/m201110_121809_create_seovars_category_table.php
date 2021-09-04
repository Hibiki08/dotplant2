<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seovars_category`.
 */
class m201110_121809_create_seovars_category_table extends Migration
{
    CONST TABLE = '{{%seovars_categories_ref}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'seo_variable_id' => $this->integer()->notNull()->unsigned(),
            'category_id' => $this->integer()->notNull()->unsigned(),
            'seo_word' => $this->string(1024)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('', self::TABLE, ['seo_variable_id', 'category_id']);

        $this->addForeignKey(
            'FK_seo_category_id',
            self::TABLE,
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE' 
        );
        
        $this->addForeignKey(
            'FK_seocateg_var_id',
            self::TABLE,
            'seo_variable_id',
            '{{%seo_category_vars}}',
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
