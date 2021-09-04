<?php

use yii\db\Migration;
use app\models\View;

/**
 * Class m200825_041227_main_page_edit
 */
class m200825_041227_main_page_edit extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('{{%page}}', [
            'slug_compiled' => ':mainpage:',
            'content' => 'You can edit content of main page in backend/page section',
        ], ['id' => 1]);

        if (!View::find()->where(['name' => 'Main page'])->one()) {
            $this->insert('{{%view}}', [
                'name' => 'Main page',
                'view' => '@app/web/theme/views/main-page/main-page.php',
            ]);
            $this->insert('{{%view_object}}', [
                'view_id' => $this->db->lastInsertID,
                'object_id' => 1,
                'object_model_id' => 1,
            ]);
        }

        $this->update('{{%view}}', ['view' => '@app/web/theme/views/main-page/main-page.php'], ['view' => '@app/extensions/demo/views/main-page.php']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update('{{%view}}', ['view' => '@app/extensions/demo/views/main-page.php'], ['view' => '@app/web/theme/views/main-page/main-page.php']);
    }
}
