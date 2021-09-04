<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seo_category_vars_category_ref`.
 */
class m201104_145557_create_seo_category_vars_category_ref_table extends Migration
{
    CONST TABLE = '{{%seo_category_vars_category_ref}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'seo_category_var_id' => $this->integer()->notNull()->unsigned(),
            'category_id' => $this->integer()->notNull()->unsigned(),
            'exclude' => $this->integer(1)->defaultValue(0),
        ], $tableOptions);

        $this->addPrimaryKey('', self::TABLE, ['seo_category_var_id', 'category_id']);

        $this->addForeignKey(
            'FK_seocat_var_id',  
            self::TABLE,
            'seo_category_var_id',
            '{{%seo_category_vars}}',
            'id',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'FK_seocatvars_category_id_ref',
            self::TABLE, 
            'category_id', 
            '{{%category}}', 
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
