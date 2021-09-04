<?php

use yii\db\Migration;

/**
 * Class m200823_230726_catalog_to_rus
 */
class m200823_230726_catalog_to_rus extends Migration
{
    const TABLE = '{{%category}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update(
            SELF::TABLE,
            [
                'name' => 'Каталог',
                'title' => 'Каталог',
                'h1' => 'Каталог',
                'breadcrumbs_label' => 'Каталог',
                ],
            ['slug' => 'catalog']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
