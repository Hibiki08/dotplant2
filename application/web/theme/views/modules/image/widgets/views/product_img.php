<?php

/**
 * @var $images \app\modules\image\models\Image[]
 * @var $this \yii\web\View
 * @var $thumbnailOnDemand boolean
 * @var $thumbnailWidth integer
 * @var $thumbnailHeight integer
 */

use kartik\helpers\Html;

if (count($images) > 0) {
    $image = reset($images);
    $image_src = $image->file;
    if ($thumbnailOnDemand === true) {
        $image_src = $image->getThumbnail("{$thumbnailWidth}x{$thumbnailHeight}", $useWatermark);
    }
} else {
    $image_src = '/theme/dist/images/no-image.png';
}
echo Html::tag('figure', '', ['style' => "background-image: url('$image_src');"]);
