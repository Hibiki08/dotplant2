<?php

use yii\db\Migration;

/**
 * Class m200909_140248_update_tranlations
 */
class m200909_140248_update_tranlations extends Migration
{
    const TABLE = '{{%page}}';

    public function safeUp()
    {
        $this->update(self::TABLE, ['title' => 'Главная страница'], ['slug' => ':mainpage:']);
        $this->update(self::TABLE, ['title' => 'О нас','name' => 'О нас','h1' => 'О нас',], ['slug' => 'about']);
        $this->update(self::TABLE, ['title' => 'Доставка','name' => 'Доставка','h1' => 'Доставка',], ['slug' => 'delivery']);
        $this->update(self::TABLE, ['title' => 'Оплата','name' => 'Оплата','h1' => 'Оплата',], ['slug' => 'payment']);
    }

    public function safeDown()
    {
    }
}
