<?php
namespace import;

use PDO;
use Exception;

include 'Images.php';

class Filters extends Images
{
    /*
        0 "Артикул",
        1 "Основная категория товара",
        2 "Подраздел категории товара",
        3 "Наименование",
        4 "Описание",
        5 "Производитель",
        6 "Артикул производителя",
        7 "Цена (Розница)",
        8 "Цена (Опт)",
        9 "Можно купить",
        10 "На складе",
        11 "Время отгрузки",
        12 "Размер",
        13 "Цвет",
        14 "aID",
        15 "Материал",
        16 "Батарейки",
        17 "Упаковка",
        18 "Вес (брутто)",
        25 "Штрихкод",
 */
    protected function saveEav($id, $groupId, $name, $value)
    {
        $key = $this->getKey($name);
        if (!isset($this->properties[$key])) {
            $this->insert(
                Property::tableName(),
                [
                    'property_group_id' => $groupId,
                    'name' => $name,
                    'key' => $key,
                    'property_handler_id' => ($this->selectHandlerId != null) ? $this->selectHandlerId : 0,
                    'handler_additional_params' => '{}',
                    'is_eav' => 1,
                    'has_slugs_in_values' => 0,
                ]
            );
            $this->properties[$key] = $this->db->lastInsertID;
        }
        $this->insert(
            '{{%product_eav}}',
            [
                'object_model_id' => $id,
                'property_group_id' => $groupId,
                'key' => $key,
                'value' => $value,
            ]
        );
    }

    public function saveStatic($id, $key, $value)
    {
        // property_static_values
        if (!isset($this->values[$value])) {
            $value = trim($value);
            $this->insert(
                PropertyStaticValues::tableName(),
                [
                    'property_id' => $this->properties[$key],
                    'name' => $value,
                    'value' => $value,
                    'slug' => Helper::createSlug($value),
                ]
            );
            $this->values[$value] = $this->db->lastInsertID;
        }
        $this->insert(
            ObjectStaticValues::tableName(),
            [
                'object_id' => BaseObject::getForClass(Product::className())->id,
                'object_model_id' => $id,
                'property_static_value_id' => $this->values[$value],
            ]
        );
    }

    public function filterSets($productId, $categoryId){
        $c = $this->pdo->query('
                      SELECT `id` FROM `theme_active_widgets`
                      WHERE `part_id` = 5 AND `widget_id` = 5 AND `variation_id` = 2 LIMIT 1');

        $result = $c->fetch(PDO::FETCH_BOTH);
        if ($result === false) {
            $this->pdo->query('
                INSERT INTO `theme_active_widgets`
                (`part_id`, `widget_id`, `variation_id`) VALUES (5, 5, 2)');
        }
    }
}