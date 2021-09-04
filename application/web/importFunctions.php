<?php
namespace app\web;

use PDO;
use Exception;

class importFunctions
{
    public $host;
    public $db;
    public $user;
    public $pass;
    public $charset = 'utf8';
    public $pdo;
    public $productObjectId = 3;
    public $values =
        [
            5 => "Производитель",
            6 => "Артикул производителя",
            7 => "Цена (Розница)",
            8 => "Цена (Опт)",
            9 => "Можно купить",
            10 => "На складе",
            11 => "Время отгрузки",
            12 => "Размер",
            13 => "Цвет",
            14 => "aID",
            15 => "Материал",
            16 => "Батарейки",
            17 => "Упаковка",
            18 => "Вес (брутто)",
            25 => "Штрихкод",
        ];

    public function __construct()
    {
        if (file_exists('db-local.php')) {
            include 'db-local.php';
            $this->host = $host;
            $this->db = $db;
            $this->user = $user;
            $this->pass = $pass;
        } else {
            $this->host = 'localhost';
            $this->db  = 'dotplant2';
            $this->user = 'root';
            $this->pass = '';
        }

        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->pdo = new PDO($dsn, $this->user, $this->pass, $opt);
    }

    /**
     * @return string
     */
    public function clearGoods()
    {
        /*
         * product
         * category
         * property_group
         * property
         * product_category
         * object_property_group
         * image
         */

    }

    public function categoryImages()
    {
        $c = $this->pdo->query('SELECT id FROM category WHERE parent_id != 1');

        foreach ($c as $row) {
            $p = $this->pdo->query('
                SELECT i.filename as filename
                FROM product p
                LEFT JOIN image i ON i.object_model_id = p.id
                WHERE p.main_category_id = ' . $row['id'] . '
                ORDER BY RAND() limit 1');
            $product = $p->fetch(PDO::FETCH_BOTH);

            copy(
                $_SERVER['DOCUMENT_ROOT'] . '/files/' . $product['filename'],
                $_SERVER['DOCUMENT_ROOT'] . '/files/category/' . $row['id'] . '.jpg'
            );
        }

        $this->categorySubGroupImages();
    }

    public function categorySubGroupImages()
    {
        $c = $this->pdo->query('SELECT id FROM category WHERE parent_id = 1');

        foreach ($c as $row) {
            $p = $this->pdo->query('
                SELECT i.filename as filename
                FROM category cat
                LEFT JOIN product p ON p.main_category_id = cat.id
                LEFT JOIN image i ON i.object_model_id = p.id
                WHERE cat.parent_id = ' . $row['id'] . '
                ORDER BY RAND() limit 1');
            $product = $p->fetch(PDO::FETCH_BOTH);

            copy(
                $_SERVER['DOCUMENT_ROOT'] . '/files/' . $product['filename'],
                $_SERVER['DOCUMENT_ROOT'] . '/files/category/' . $row['id'] . '.jpg'
            );
        }
    }

    public function createCategory()
    {
        copy('http://stripmag.ru/datafeed/p5s_assort.csv', $_SERVER['DOCUMENT_ROOT'] . '/files/p5s_assort.csv');
        $data = file($_SERVER['DOCUMENT_ROOT'] . '/files/p5s_assort.csv');
        $start = 1;
        $dataSize = sizeof($data);
        // создадим первый уровень групп
        for ($i = $start; $i < $dataSize; $i++) {
            $line = explode(';', str_replace('"', '', $data[$i]));
            // Запись основной категории
            $lastId = $this->categoryInsert($i, 1, $line[1]);
        }

        $c = $this->pdo->query('SELECT id FROM property_group WHERE `name` = "Общая группа свойств" limit 1');
        $result = $c->fetch(PDO::FETCH_BOTH);
        if ($result === false) {
            $this->pdo->query('INSERT INTO `property_group` (`object_id`, `name`) VALUES ( 1, "Общая группа свойств")');
            $commonGroupId = $this->pdo->lastInsertId();
        } else {
            $commonGroupId = $result['id'];
        }

        $c = $this->pdo->query('SELECT id FROM property WHERE `property_group_id` = ' . $commonGroupId . ' limit 1');
        $result = $c->fetch(PDO::FETCH_BOTH);
        if ($result === false) {
            $this->pdo->query('INSERT INTO `property` 
            (
                `property_group_id`, 
                `name`, 
                `key`, 
                `property_handler_id`, 
                `handler_additional_params`, 
                `has_static_values`, 
                `has_slugs_in_values`
            ) VALUES (
                "' . $commonGroupId . '", 
                "Производитель", 
                "vendor", 
                2, 
                "{}", 
                1, 
                1
            )');
        }

        return '<script>window.location.href="/import.php?stage=sub&start=1&commonGroupId=' . $commonGroupId . '"</script>';
    }

    public function createSubCategory($start)
    {
        $commonGroupId = $_GET['commonGroupId'];
        $data = file($_SERVER['DOCUMENT_ROOT'] . '/files/p5s_assort.csv');
        $dataEnd = $start+49;
        $dataSize = sizeof($data);
        $stop = 0;
        if ($dataSize <= $dataEnd) {
            $dataEnd = $dataSize;
            $stop = 1;
        }
        // добавим под уровень
        for ($m = $start; $m < $dataEnd; $m++) {
            $subLine = explode(';', str_replace('"', '', $data[$m]));
            $c = $this->pdo->query('SELECT id FROM category WHERE `name` = "' . $subLine[1] . '" limit 1');
            $result = $c->fetch(PDO::FETCH_BOTH);
            $categoryId = $this->categoryInsert($m, $result['id'], $subLine[2]);

            $productId = $this->productAdd($subLine, $categoryId);

            if ($productId != 0) {
                $this->imagesAdd($subLine);

                $this->pdo->query('
                  INSERT INTO `product_category`
                  (`category_id`, `object_model_id`)
                  VALUES
                  (1, ' . $productId . ')');

                $this->pdo->query('
                  INSERT INTO `product_category`
                  (`category_id`, `object_model_id`)
                  VALUES
                  (' . $result['id'] . ', ' . $productId . ')');

                $this->pdo->query('
                  INSERT INTO `product_category`
                  (`category_id`, `object_model_id`)
                  VALUES
                  (' . $categoryId . ', ' . $productId . ')');

                $this->pdo->query('
                  INSERT INTO `object_property_group`
                  (`object_id`, `object_model_id`, `property_group_id`)
                  VALUES
                  (' . $this->productObjectId . ', ' . $productId . ', ' . $commonGroupId . ')');
                $this->pdo->query('
                  INSERT INTO `object_property_group`
                  (`object_id`, `object_model_id`, `property_group_id`)
                  VALUES
                  (' . $this->productObjectId . ', ' . $productId . ', ' . $categoryId . ')');
            }
        }

        if ($stop == 0) {
            return 
                '<div>'.($start + 50).' / ' . $dataSize . '</div>' .
                '<script>window.location.href="/import.php?stage=sub&start=' . ($start + 50) . '&commonGroupId=' . $commonGroupId . '"</script>'
                ;
        } else {
            return 'finish';
        }
    }

    public function categoryInsert($sort, $parent, $name)
    {
        $c = $this->pdo->query('SELECT id FROM category WHERE `name` = "' . $name . '" limit 1');
        $result = $c->fetch(PDO::FETCH_BOTH);
        if ($result === false) {
            $this->pdo->query('
                  INSERT INTO `category`
                    (
                        `category_group_id`,
                        `parent_id`,
                        `name`,
                        `title`,
                        `h1`,
                        `meta_description`,
                        `breadcrumbs_label`,
                        `slug`,
                        `slug_compiled`,
                        `slug_absolute`,
                        `sort_order`,
                        `active`
                    ) VALUE (
                        1,
                        ' . $parent . ',
                        "' . $name . '",
                        "' . $name . '",
                        "' . $name . '",
                        "' . $name . '",
                        "' . $name . '",
                        "' . $this->slugHelper($name) . '",
                        "' . $this->slugHelper($name) . '",
                        0,
                        ' . $sort . ',
                        1
                    )
                  ');

            return $this->pdo->lastInsertId();
        } else {
            return $result['id'];
        }
    }

    public function productAdd($subLine, $lastId)
    {
        try {
            return $this->productInsert($lastId, $subLine);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function productInsert($categoryId, $productData)
    {
        $c = $this->pdo->query('SELECT id FROM product WHERE `name` = "' . $productData[3] . '" limit 1');
        $result = $c->fetch(PDO::FETCH_BOTH);

        if ($result === false) {
            $this->pdo->query('
                  INSERT INTO `product`
                    (
                        `parent_id`,
                        `measure_id`,
                        `currency_id`,
                        `main_category_id`,
                        `name`,
                        `title`,
                        `breadcrumbs_label`,
                        `h1`,
                        `slug`,
                        `announce`,
                        `content`,
                        `price`,
                        `old_price`,
                        `sku`
                    ) VALUE (
                        0,
                        1,
                        1,
                        ' . $categoryId . ',
                        "' . $productData[3] . '",
                        "' . $productData[3] . '",
                        "' . $productData[3] . '",
                        "' . $productData[3] . '",
                        "' . $this->slugHelper($productData[3]) . '",
                        "' . $this->trimPlain($productData[3]) . '",
                        "' . $productData[4] . '",
                        ' . $productData[7] . ',
                        ' . $productData[7] * 1.15 . ',
                        ' . $productData[25] . '
                    )
                  ');
        } else {
            $this->pdo->query('
                UPDATE `product`
                SET 
                    `parent_id` = 0,
                    `measure_id` = 1,
                    `currency_id` = 1,
                    `main_category_id` = ' . $categoryId . ',
                    `name` = "' . $productData[3] . '",
                    `title` = "' . $productData[3] . '",
                    `breadcrumbs_label` = "' . $productData[3] . '",
                    `h1` = "' . $productData[3] . '",
                    `slug` = "' . $this->slugHelper($productData[3]) . '",
                    `announce` = "' . $this->trimPlain($productData[3]) . '",
                    `content` = "' . $productData[4] . '",
                    `price` = ' . $productData[7] . ',
                    `old_price` = ' . $productData[7] * 1.15 . ',
                    `sku` = ' . $productData[25] . '
                WHERE `id` = ' . $result['id'] .'
            ');
        }

        if ($result === false) {
            return $this->pdo->lastInsertId();
        } else {
            return $result['id'];
        }
    }

    public function imagesAdd($subLine)
    {
        $c = $this->pdo->query('SELECT id FROM product WHERE `name` = "' . $subLine[3] . '" limit 1');
        $result = $c->fetch(PDO::FETCH_BOTH);

        // 20 "Фотография 1",
        // 21 "Фотография 2",
        // 22 "Фотография 3",
        // 23 "Фотография 4",
        // 24 "Фотография 5",

        for ($i = 19; $i < 25; $i++) {
            if ($subLine[$i] != '') {
                $image = $this->urlImage($subLine[$i]);
                if ($i == 19) {
                    $smallImage = preg_replace(array('/small_/', '/\.jpg/'), array('', '-180x180.jpg'), $image);
                    copy($subLine[$i], $_SERVER['DOCUMENT_ROOT'] . '/files/thumbnail/' . $smallImage);
                } else {
                    if ($this->testImage($image)) {
                        $this->pdo->query('
                        INSERT INTO `image`
                        (
                            `object_id`,
                            `object_model_id`,
                            `filename`,
                            `image_alt`,
                            `sort_order`,
                            `image_title`
                        ) VALUES (
                            ' . $this->productObjectId . ',
                            "' . $result['id'] . '",
                            "' . $image . '",
                            "' . $subLine['3'] . '",
                            ' . $i . ',
                            "' . $subLine['3'] . '"
                        ) 
                    ');
                        copy($subLine[$i], $_SERVER['DOCUMENT_ROOT'] . '/files/' . $image);
                    }
                }
            }
        }
    }

    public function testImage($image)
    {
        $c = $this->pdo->query('SELECT id FROM image WHERE `filename` = "' . $image . '" limit 1');
        $result = $c->fetch(PDO::FETCH_BOTH);
        if ($result === false) {
            return true;
        } else {
            return false;
        }
    }

    public function slugHelper($name)
    {
        return str_replace('-', '_', $this->createSlug($name));
    }

    public function createSlug($source)
    {
        $source = mb_strtolower($source);
        $translateArray = [
            "ый" => "y", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "c", "ч" => "ch" ,"ш" => "sh", "щ" => "sch", "ъ" => "",
            "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
            " " => "-", "." => "", "/" => "-", "_" => "-"
        ];
        $source = preg_replace('#[^a-z0-9\-]#is', '', strtr($source, $translateArray));
        return trim(preg_replace('#-{2,}#is', '-', $source));
    }

    public function trimPlain($text, $length = 150, $dots = '...')
    {
        if (!is_string($text) && empty($text)) {
            return "";
        }
        $length = intval($length);
        $text = trim(strip_tags($text));
        $pos = mb_strrpos(mb_substr($text, 0, $length), ' ');
        $string = mb_substr($text, 0, $pos);
        if (!empty($string)) {
            return $string.$dots;
        } else {
            return "";
        }
    }

    public function urlImage($url)
    {
        $urlData = explode('/', $url);

        return $urlData[count($urlData)-1];
    }

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