<?php

return [
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@webroot/theme/views/modules/basic',
                    '@app/modules/shop/views' => '@webroot/theme/views/modules/shop',
                    '@app/modules/page/views' => '@webroot/theme/views/modules/page',
                    '@app/modules/cabinet' => '@webroot/theme/views/modules/cabinet',
                    '@app/widgets' => '@webroot/theme/views/widgets',
                    '@app/properties' => '@webroot/theme/views/properties',
                    '@app/modules/image/widgets' => '@webroot/theme/views/modules/image/widgets',
                    '@app/modules/shop/widgets' => '@webroot/theme/views/modules/shop/widgets',
                    '@app/modules/user' => '@webroot/theme/views/modules/user',
                    '@app/extensions/DefaultTheme/widgets' => '@webroot/theme/widgets',
                    '@app/modules/image/widgets/views' => '@webroot/theme/widgets/image',
                    //'@app/modules/shop/widgets/views' => '@webroot/theme/views/modules/shop/widgets/views',
                    '@app/extensions/DefaultTheme/widgets/FilterSets/views' => '@webroot/theme/widgets/FilterSets/views',
                ],
                'baseUrl' => '@webroot/theme/views',
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<action:payment|delivery|contacts|help|info>' => 'site/about/<action>',
            ],
        ],
    ],
    'modules' => [
        'site' => [
            'class' => 'app\web\theme\module\ThemeModule',
            'controllerNamespace' => 'app\web\theme\module\controllers',
        ]
    ],
    'bootstrap' => [
        'site',
    ],
];
