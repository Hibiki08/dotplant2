<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Default DotPlant2 asset bundle for frontend.
 * You can use your own, but don't forget to include CMS js and css files.
 *
 * @package app\assets
 */
class SimpleBar extends AssetBundle
{
    public $sourcePath = '@app/assets/app';
    public $css = [
        'css/simplebar.css',
    ];
    public $js = [
        'js/simplebar.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
