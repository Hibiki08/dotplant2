<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Default DotPlant2 fancybox asset bundle for frontend.
 * You can use your own, but don't forget to include CMS js and css files.
 *
 * @package app\assets
 */
class FancyBox350 extends AppAsset
{

    public $sourcePath = '@app/assets/app';
    public $css = [
        'js/fancybox350/jquery.fancybox.min.css'
    ];
    public $js = [
        'js/fancybox350/jquery.fancybox.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
