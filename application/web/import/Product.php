<?php
namespace app\web\import;

use PDO;
use Exception;

include 'Filters.php';

class Product extends Filters
{

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
}