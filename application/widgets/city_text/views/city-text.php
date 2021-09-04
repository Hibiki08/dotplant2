<?php

use app\models\City;
use yii\web\View;

/**
 * @var View $this
 * @var City[] $cities
 * @var string $text
 * @var string $key
 * @var string|callable $cityAttribute
 */

if (count($cities) === 0) {
    return;
}

if (strlen($text) === 0) {
    return;
}
?>
<?php foreach ($cities as $city) { ?>
    <?php
        $cityName = is_callable($cityAttribute)
            ? call_user_func($cityAttribute, [$city])
            : $city->{$cityAttribute};

        if (strlen($cityName) === 0) {
            continue;
        }
    ?>
    <?= str_replace($key, $cityName, $text) ?>
<?php } ?>
