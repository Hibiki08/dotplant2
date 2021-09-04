<?php

use yii\db\Migration;

/**
 * Class m201020_180051_add_cities_setting_to_admin_menu
 */
class m201020_180051_add_cities_setting_to_admin_menu extends Migration
{
    const TABLE = '{{%backend_menu}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(self::TABLE, [
            'parent_id' => 18,
            'name' => 'Cities',
            'route' => 'backend/city/index',
            'icon' => 'tasks',
            'sort_order' => 16,
            'added_by_ext' => 'core',
            'rbac_check' => 'content manage',
            'css_class' => '',
            'translation_category' => 'app',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete(self::TABLE, [
            'parent_id' => 18,
            'name' => 'Cities',
            'route' => 'backend/city/index',
        ]);
    }
}
