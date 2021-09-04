<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Default DotPlant2 asset bundle for frontend.
 * You can use your own, but don't forget to include CMS js and css files.
 *
 * @package app\assets
 */
class OwlCarousel extends AssetBundle
{
    public $sourcePath = '@app/assets/app';
    public $css = [
        'js/owlcarousel/assets/owl.carousel.min.css',
        'js/owlcarousel/assets/owl.theme.default.min.css',
        'js/owlcarousel/assets/owl.theme.green.min.css',
    ];
    public $js = [
        'js/owlcarousel/owl.carousel.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
