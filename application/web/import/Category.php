<?php
namespace app\web\import;

use PDO;
use Exception;

include 'Product.php';

class Category extends Product
{

    public function categoryImages()
    {
        $c = $this->pdo->query('SELECT id FROM category WHERE 1=1');

        foreach ($c as $row) {
            $p = $this->pdo->query('
                SELECT i.filename as filename
                FROM product p
                LEFT JOIN image i ON i.object_model_id = p.id
                WHERE p.main_category_id = ' . $row['id'] . '
                ORDER BY RAND() limit 1');
            $product = $p->fetch(PDO::FETCH_BOTH);

            if ($product === false) {
                $cc = $this->pdo->query('
                    SELECT id FROM category WHERE parent_id = ' . $row['id'] . ' LIMIT 1');
                $category = $cc->fetch(PDO::FETCH_BOTH);

                $p = $this->pdo->query('
                    SELECT i.filename as filename
                    FROM product p
                    LEFT JOIN image i ON i.object_model_id = p.id
                    WHERE p.main_category_id = ' . $category['id'] . '
                    ORDER BY RAND() limit 1');
                $product = $p->fetch(PDO::FETCH_BOTH);
            }

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
            return '<script>window.location.href="/import.php?stage=sub&start=' . ($start + 50) . '&commonGroupId=' . $commonGroupId . '"</script>';
        }else {
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
}