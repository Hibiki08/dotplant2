<?php

use app\traits\GetImages;
use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $thumbnailOnDemand boolean
 * @var $useWatermark boolean
 * @var $thumbnailWidth integer
 * @var $thumbnailHeight integer
 * @var $model \app\properties\HasProperties|\yii\db\ActiveRecord|GetImages|null
 */

$image_src = '/theme/images/no-image.png';

$attr = ['title' => '', 'alt' => 'no img', ];
if ($thumbnailHeight > 0) {
    $attr['style'] = 'width:auto;height:' . $thumbnailHeight . 'px';
} elseif($thumbnailWidth > 0) {
    $attr['style'] = 'height:auto;width:' . $thumbnailWidth . 'px';
}

$imgHtml = Html::img($image_src, $attr);
echo Html::tag('div', $imgHtml);
