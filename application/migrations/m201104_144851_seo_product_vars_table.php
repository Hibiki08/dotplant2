<?php

use yii\db\Migration;

/**
 * Class m201104_144851_seo_product_vars_table
 */
class m201104_144851_seo_product_vars_table extends Migration
{
    CONST TABLE = '{{%seo_product_vars}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey()->unsigned(),
            'word' => $this->string(1024)->notNull()->comment('Шаблон для вывода в Seo-тексты'),
            'example' => $this->string(1024)->notNull()->comment('Пример'),
            'description' => $this->string(1024)->comment('Краткое описание шаблона'),
        ], $tableOptions);

        $this->createIndex('indx_seo_word', self::TABLE, ['word']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
