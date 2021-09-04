<?php

use yii\db\Migration;

/**
 * Class m201130_001934_add_indexes
 */
class m201130_001934_add_indexes extends Migration
{
    public function safeUp()
    {
        $this->createIndex('indx_for_update', '{{%product_eav}}', ['key', 'object_model_id', 'property_group_id']);
        $this->createIndex('indx_for_update1', '{{%property_static_values}}', ['value', 'property_id']);
    }


    public function safeDown()
    {
        $this->dropIndex('indx_for_update', '{{%product_eav}}');
        $this->dropIndex('indx_for_update1', '{{%property_static_values}}');
    }
}
