<?php

use yii\db\Migration;

/**
 * Class m200823_161145_config_widget
 */
class m200823_161145_config_widget extends Migration
{
    const TABLE = '{{%theme_widgets}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(self::TABLE, ['configuration_json' => json_encode(['usePjax' => true, 'useNewFilter' => true,])], ['widget' => 'app\extensions\DefaultTheme\widgets\FilterSets\Widget']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->update(self::TABLE, ['configuration_json' => '{}',], ['widget' => 'app\extensions\DefaultTheme\widgets\FilterSets\Widget']);
    }
}
