<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Default DotPlant2 asset bundle for frontend.
 * You can use your own, but don't forget to include CMS js and css files.
 *
 * @package app\assets
 */
class Modernizr170 extends AssetBundle
{
    public $sourcePath = '@app/assets/app';
    public $css = [];
    public $js = [
        'js/modernizr170.js',
    ];
}
