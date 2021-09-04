<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_history`.
 */
class m201203_081540_create_product_history_table extends Migration
{
    CONST TABLE = '{{%product_history}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE, [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'productId' => $this->integer()->notNull(),
            'attribute' => $this->string(255)->notNull(),
            'oldvalue' => $this->text(),
            'newvalue' => $this->text(),
        ], $tableOptions);

        $this->createIndex('prhist-1',self::TABLE,['productId']);
        $this->createIndex('prhist-2',self::TABLE,['attribute']);


    }
    
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}