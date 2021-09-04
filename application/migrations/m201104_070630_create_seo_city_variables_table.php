<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seo_city_variables`.
 */
class m201104_070630_create_seo_city_variables_table extends Migration
{
    CONST TABLE = '{{%seo_city_variables}}';
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
