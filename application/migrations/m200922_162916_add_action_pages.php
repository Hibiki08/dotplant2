<?php

use yii\db\Migration;

/**
 * Class m200922_162916_add_action_pages
 */
class m200922_162916_add_action_pages extends Migration
{
    const TABLE = '{{%page}}';

    private $data = [
        [
            'parent_id' => 1,
            'slug' => 'about-prices',
            'slug_compiled' => 'about-prices',
            'name' => 'Гарантия низкой цены',
            'title' => 'Гарантия низкой цены',
            'h1' => 'Гарантия низкой цены',
        ],
        [
            'parent_id' => 1,
            'slug' => 'about-bonuses',
            'slug_compiled' => 'about-bonuses',
            'name' => 'Бонусная программа',
            'title' => 'Бонусная программа',
            'h1' => 'Бонусная программа',
        ],
        [
            'parent_id' => 1,
            'slug' => 'about-cashback',
            'slug_compiled' => 'about-cashback',
            'name' => '20% кэшбэк',
            'title' => '20% кэшбэк',
            'h1' => '20% кэшбэк',
        ],
        [
            'parent_id' => 1,
            'slug' => 'about-delivery',
            'slug_compiled' => 'about-delivery',
            'name' => 'Быстрая и бережная доставка',
            'title' => 'Быстрая и бережная доставка',
            'h1' => 'Быстрая и бережная доставка',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach ($this->data as $row) {
            $this->insert(self::TABLE, $row);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->data as $row) {
            $this->delete(self::TABLE, ['slug' => $row['slug'], 'slug_compiled' => $row['slug_compiled']]);
        }
    }
}
