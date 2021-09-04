<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seo_product_vars_product_ref`.
 */
class m201104_145634_create_seo_product_vars_product_ref_table extends Migration
{
    CONST TABLE = '{{%seo_product_vars_product_ref}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'seo_product_var_id' => $this->integer()->notNull()->unsigned(),
            'product_id' => $this->integer()->notNull()->unsigned(),
            'exclude' => $this->integer(1)->defaultValue(0),
        ], $tableOptions);

        $this->addPrimaryKey('', self::TABLE, ['seo_product_var_id', 'product_id']);

        $this->addForeignKey(
            'FK_seo_product_var_id',  
            self::TABLE,
            'seo_product_var_id',
            '{{%seo_product_vars}}',
            'id',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'FK_product_id',
            self::TABLE, 
            'product_id', 
            '{{%product}}', 
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
