<?php

use yii\db\Migration;

/**
 * Handles the creation of table `seo_texts`.
 */
class m201104_132347_create_seo_texts_table extends Migration
{
    CONST TABLE = '{{%seo_texts}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey()->unsigned(),
            'text' => $this->string(20000)->notNull(),
            'description' => $this->string(1024)->notNull(),
            'published' => $this->integer(1)->defaultValue(1),
            'inProduct' => $this->integer(1)->defaultValue(0),
            'inCategory' => $this->integer(1)->defaultValue(10),
        ], $tableOptions);

        $this->createIndex('indx_seo_txt_pub', self::TABLE, ['published']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}
