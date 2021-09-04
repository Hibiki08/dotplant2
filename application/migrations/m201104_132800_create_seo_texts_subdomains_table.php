<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seo_texts_subdomains`.
 */
class m201104_132800_create_seo_texts_subdomains_table extends Migration
{
    CONST TABLE = '{{%seo_texts_subdomains}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('seo_texts_subdomains', [
            'seo_text_id' => $this->integer()->notNull()->unsigned(),
            'subdomain_id' => $this->integer()->notNull(),
            'exclude' => $this->integer(1)->defaultValue(0),
        ], $tableOptions);

        $this->addPrimaryKey('', self::TABLE, ['seo_text_id', 'subdomain_id', 'exclude',]);

        $this->addForeignKey(
            'FK_seotxt_id',  
            self::TABLE,
            'seo_text_id',
            '{{%seo_texts}}',
            'id',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'FK_subdomain_id',
            self::TABLE, 
            'subdomain_id', 
            '{{%subdomain}}', 
            'id', 
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('seo_texts_subdomains');
    }
}
