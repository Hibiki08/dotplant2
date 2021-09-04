<?php

use yii\db\Migration;

/**
 * Class m201121_083829_add_item_to_backend_menu
 */
class m201121_083829_add_item_to_backend_menu extends Migration
{
    const TABLE = '{{%backend_menu}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(self::TABLE, [
            'parent_id' => 1,
            'name' => 'Сео Тексты',
            'route' => 'seotext',
            'icon' => 'tasks',
            'added_by_ext' => 'core',
            'rbac_check' => 'seo manage',
            'css_class' => '',
            'translation_category' => 'app',
            'sort_order' => '9',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE, [
            'route' => 'seotext',
        ]);
    }
}
