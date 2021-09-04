<?php

/**
 * @var $images \app\modules\image\models\Image[]
 * @var $this \yii\web\View
 * @var $thumbnailOnDemand boolean
 * @var $thumbnailWidth integer
 * @var $thumbnailHeight integer
 */

use app\modules\image\models\Image;
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

function renderImg($src, $title, $alt) {
    $imgHtml = Html::tag(
        'figure',
        '',
        [
            'style' => "background-image: url('{$src}');",
            'title' => $title,
            'alt' => $alt,
            'itemprop' => 'contentUrl',
        ]
    );
    $divHtml = Html::tag('div', $imgHtml, ['class' => 'product-slider-image']);
    $aHtml = Html::a($divHtml, [$src], ['data-fancybox' => true]);
    return Html::tag('div', $aHtml, ['class' => 'item']);
}

if (count($images) > 0) {
    foreach ($images as $image) {
        $image_src = $image->file;
        if ($thumbnailOnDemand === true) {
            $image_src = $image->getThumbnail("{$thumbnailWidth}x{$thumbnailHeight}", $useWatermark);
        }
        $title = $image->image_title;
        $alt = $image->image_alt;
        if (empty($image->image_alt) === true) {
            $alt = $title;
        }
        echo renderImg($image_src, $title, $alt);
    }
} else {
    echo renderImg('/theme/dist/images/no-image.png', '', 'no-image');
}
