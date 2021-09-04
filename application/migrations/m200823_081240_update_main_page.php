<?php

use yii\db\Migration;
use yii\helpers\Console;

/**
 * Class m200823_081240_update_main_page
 */
class m200823_081240_update_main_page extends Migration
{
    const TABLE = '{{%view}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $objectModelId = \app\models\BaseObject::find()->select('id')->where(['object_class' => 'app\modules\page\models\Page'])->scalar();
        $viewId = \app\models\ViewObject::find()->select('view_id')->where([
            'object_id' => 1,
            'object_model_id' => $objectModelId,
        ])->scalar();
        $this->update(self::TABLE, ['view' => '@app/web/theme/views/main-page/main-page.php'], ['id' => $viewId,]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $objectModelId = \app\models\BaseObject::find()->select('id')->where(['object_class' => 'app\modules\page\models\Page'])->scalar();
        $viewId = \app\models\ViewObject::find()->select('view_id')->where([
            'object_id' => 1,
            'object_model_id' => $objectModelId,
        ])->scalar();
        $this->update(self::TABLE,['view' => '@app/extensions/demo/views/main-page.php'], ['id' => $viewId]);
    }
}
