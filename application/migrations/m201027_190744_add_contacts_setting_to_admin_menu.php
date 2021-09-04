<?php

use yii\db\Migration;

/**
 * Class m201027_190744_add_contacts_setting_to_admin_menu
 */
class m201027_190744_add_contacts_setting_to_admin_menu extends Migration
{
    const TABLE = '{{%backend_menu}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(self::TABLE, [
            'parent_id' => 18,
            'name' => 'Contacts',
            'route' => 'backend/contact/index',
            'icon' => 'tasks',
            'sort_order' => 18,
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
            'name' => 'Contacts',
            'route' => 'backend/contact/index',
        ]);
    }
}
