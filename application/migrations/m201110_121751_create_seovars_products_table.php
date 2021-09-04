<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seovars_products`.
 */
class m201110_121751_create_seovars_products_table extends Migration
{
    CONST TABLE = '{{%seovars_products_ref}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'seo_variable_id' => $this->integer()->notNull()->unsigned(),
            'product_id' => $this->integer()->notNull()->unsigned(),
            'seo_word' => $this->string(1024)->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('', self::TABLE, ['seo_variable_id', 'product_id']);

        $this->addForeignKey(
            'FK_seo_product_id',
            self::TABLE,
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE' 
        );
        
        $this->addForeignKey(
            'FK_seopr_var_id',
            self::TABLE,
            'seo_variable_id',
            '{{%seo_product_vars}}',
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
