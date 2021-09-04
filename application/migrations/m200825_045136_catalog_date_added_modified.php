<?php

use yii\db\Migration;
use app\modules\shop\models\Category;
use app\modules\shop\models\Product;

/**
 * Class m200825_045136_catalog_date_added_modified
 */
class m200825_045136_catalog_date_added_modified extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $category = new Category();
        $product = new Product();

        if(!$category->hasAttribute('date_added')) {
            $this->addColumn('{{%category}}', 'date_added', 'timestamp');
        }
        if(!$category->hasAttribute('date_modified')) {
            $this->addColumn('{{%category}}', 'date_modified', 'timestamp');
        }

        if(!$product->hasAttribute('date_added')) {
            $this->addColumn('{{%product}}', 'date_added', 'timestamp');
        }
        if(!$product->hasAttribute('date_modified')) {
            $this->addColumn('{{%product}}', 'date_modified', 'timestamp');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $category = new Category();
        $product = new Product();

        if($category->hasAttribute('date_added')) {
            $this->dropColumn('{{%category}}', 'date_added');
        }
        if($category->hasAttribute('date_modified')) {
            $this->dropColumn('{{%category}}', 'date_modified');
        }

        if($product->hasAttribute('date_added')) {
            $this->dropColumn('{{%product}}', 'date_added');
        }
        if($product->hasAttribute('date_modified')) {
            $this->dropColumn('{{%product}}', 'date_modified');
        }
    }
}
