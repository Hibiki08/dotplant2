<?php

use yii\db\Migration;

/**
 * Class m201125_231934_add_indexes
 */
class m201125_231934_add_indexes extends Migration
{
    public function safeUp()
    {
        $this->createIndex('indx_product_slug', '{{%product}}', ['slug']);
        $this->createIndex('indx_product_slug_cat', '{{%product}}', ['slug', 'main_category_id']);
        $this->createIndex('csvimp-aId-imp','{{%csv_import}}',['aId', 'imported']);
    }


    public function safeDown()
    {
        $this->dropIndex('indx_product_slug', '{{%product}}');
        $this->dropIndex('indx_product_slug_cat', '{{%product}}');
        $this->dropIndex('csvimp-aId-imp','{{%csv_import}}');
    }
}
