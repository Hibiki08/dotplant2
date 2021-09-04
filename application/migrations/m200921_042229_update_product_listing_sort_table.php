<?php

use yii\db\Migration;

/**
 * Class m200921_042229_update_product_listing_sort_table
 */
class m200921_042229_update_product_listing_sort_table extends Migration
{
    const TABLE = '{{%product_listing_sort}}';

    public function safeUp()
    {
        $this->update(self::TABLE, ['name' => 'Популярность',], ['sort_field' => 'product.sort_order', 'asc_desc' => 'asc']);
        $this->update(self::TABLE, ['name' => 'Цена (по возрастанию)',], ['sort_field' => 'product.price', 'asc_desc' => 'asc']);
        $this->update(self::TABLE, ['name' => 'Цена (по убыванию)',], ['sort_field' => 'product.price', 'asc_desc' => 'desc']);
        $this->update(self::TABLE, ['name' => 'Наименование (А-Я)',], ['sort_field' => 'product.name', 'asc_desc' => 'asc']);
        $this->update(self::TABLE, ['name' => 'Наименование (Я-А)',], ['sort_field' => 'product.name', 'asc_desc' => 'desc']);
    }

    public function safeDown()
    {
    }

}
