<?php

use yii\db\Migration;

/**
 * Handles the creation of table `_seo_texts_categories`.
 */
class m201216_042121_create__seo_texts_categories_table extends Migration
{
    CONST TABLE = '{{%seo_texts_categories}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'seo_text_id' => $this->integer()->notNull()->unsigned(),
            'category_id' => $this->integer()->notNull()->unsigned(),
        ], $tableOptions);

        $this->addPrimaryKey('', self::TABLE, ['seo_text_id', 'category_id']);

        $this->addForeignKey(
            'FK_seo_cat_id',
            self::TABLE,
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE' 
        );
        
        $this->addForeignKey(
            'FK_seo_var_id',
            self::TABLE,
            'seo_text_id',
            '{{%seo_texts}}',
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