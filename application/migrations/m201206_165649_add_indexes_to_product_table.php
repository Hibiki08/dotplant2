<?php

use yii\db\Migration;

/**
 * Class m201206_165649_add_indexes_to_product_table
 */
class m201206_165649_add_indexes_to_product_table extends Migration
{
    public function safeUp()
    {
        $this->createIndex('indx_sort', '{{%product}}', 'sort_order');
        $this->createIndex('indx_active', '{{%product}}', 'active');
        $this->createIndex('indx_active_id', '{{%product}}', ['active', 'id']);
        $this->createIndex('indx_catgr', '{{%category}}', 'category_group_id');
        $this->createIndex('indx_catact', '{{%category}}', 'active');
        $this->createIndex('indx_catgract', '{{%category}}', ['active', 'category_group_id']);
        $this->createIndex('indx_catgractid', '{{%category}}', ['id', 'active', 'category_group_id']);
    }


    public function safeDown()
    {
        $this->dropIndex('indx_sort', '{{%product}}');
        $this->dropIndex('indx_active', '{{%product}}');
        $this->dropIndex('indx_catgr', '{{%category}}');
        $this->dropIndex('indx_catact', '{{%category}}');
        $this->dropIndex('indx_catgract', '{{%category}}');
        $this->dropIndex('indx_catgractid', '{{%category}}');
        $this->dropIndex('indx_active_id', '{{%product}}');
    }
}