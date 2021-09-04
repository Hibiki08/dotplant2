<?php

namespace app\web\theme\module\assets;
use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $basePath = '@webroot/theme/dist';
    public $baseUrl = '@web/theme/dist';
    public $css = [
        // your css files will be here
        "styles/custom.css",
        "styles/styles.css",
    ];
    public $js = [
        // your js files will be here
        "scripts/main.min.js",
        "scripts/main.js",
    ];
    public $depends = [
        'app\assets\AppAsset',
        'app\assets\OwlCarousel',
        'app\assets\MenuAim',
        'app\assets\FadeInUmd',
        'app\assets\Modernizr170',
        'app\assets\FancyBox350',
        '\app\assets\SimpleBar',
    ];
}
