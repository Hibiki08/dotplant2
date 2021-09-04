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
if (count($texts) === 0) {
    return;
}
?>
<?php foreach ($texts as $cityId => $cityTexts) { ?>
    <?php foreach ($cityTexts as $text): ?>
        <div><?= $text ?></div>
    <?php endforeach; ?>
    <div><?= $aboutCities[$cityId] ?></div> 
<?php } ?>
