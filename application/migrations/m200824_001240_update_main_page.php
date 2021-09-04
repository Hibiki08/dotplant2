<?php

use yii\db\Migration;

/**
 * Class m200824_001240_update_main_page
 */
class m200824_001240_update_main_page extends Migration
{
    const TABLE = '{{%view}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(self::TABLE, ['view' => '@app/web/theme/views/main-page/main-page.php'], ['view' => '@app/extensions/demo/views/main-page.php']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update(self::TABLE,['view' => '@app/extensions/demo/views/main-page.php'], ['view' => '@app/web/theme/views/main-page/main-page.php']);
    }
}
