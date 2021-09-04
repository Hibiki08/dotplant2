<?php
namespace import;

use PDO;
use Exception;

include 'Functions.php';

class Images extends Functions
{
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
}