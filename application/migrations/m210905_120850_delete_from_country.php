<?php

use yii\db\Migration;

/**
 * Class m210905_120850_delete_from_country
 */
class m210905_120850_delete_from_country extends Migration
{
    const TABLE = '{{%country}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete(self::TABLE, [
            'slug' => 'usa'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->insert(
            self::TABLE,
            [
                'name' => 'USA',
                'iso_code' => 'USA',
                'sort_order' => 1,
                'slug' => 'usa',
            ]
        );
    }
}
