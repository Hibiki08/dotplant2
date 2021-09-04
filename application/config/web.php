<?php

use yii\helpers\ArrayHelper;

// $psrLogger should be an instance of PSR-3 compatible logger.
// As an example, we'll use Monolog to send log to Slack.
$psrLogger = new \Monolog\Logger('my_logger');
$psrLogger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout', \Monolog\Logger::DEBUG));


$config = [
    'id' => 'dotplant2',
    'basePath' => dirname(__DIR__),
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'bootstrap' => [
        'core',
        'seo',
        'backend',
        'app\components\UserPreferencesBootstrap',
        'shop',
        'DefaultTheme',
        'log',
    ],
    'defaultRoute' => 'default',
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\UserModule',
            'loginSessionDuration' => 2592000,
        ],
        'shop' => [
            'class' => 'app\modules\shop\ShopModule',
        ],
        'page' => [
            'class' => 'app\modules\page\PageModule',
        ],
        'backend' => [
            'class' => 'app\backend\BackendModule',
            'layout' => '@app/backend/views/layouts/main',
            'administratePermission' => 'administrate',
        ],
        'background' => [
            'class' => 'app\backgroundtasks\BackgroundTasksModule',
            'layout' => '@app/backend/views/layouts/main',
            'controllerNamespace' => 'app\backgroundtasks\controllers',
            'notifyPermissions' => ['task manage'],
            'manageRoles' => ['admin'],
        ],
        'imp' => [
            'class' => 'app\modules\import\ImportModule',
        ],
        'seo' => [
            'class' => 'app\modules\seo\SeoModule',
        ],
        'seotext' => [
            'class' => 'app\modules\seotext\SeoTextModule',
        ],
        'review' => [
            'class' => 'app\modules\review\ReviewModule',
        ],
        'data' => [
            'class' => 'app\modules\data\DataModule',
        ],
        'dynagrid' =>  [
            'class' => '\kartik\dynagrid\Module',
            'dbSettings' => [
                'tableName' => '{{%dynagrid}}',
            ],
            'dbSettingsDtl' => [
                'tableName' => '{{%dynagrid_dtl}}',
            ],
            'dynaGridOptions' => [
                'storage' => 'db',
                'gridOptions' => [
                    'toolbar' => [
                        '{dynagrid}',
                        '{toggleData}',
                        //'{export}',
                    ],
                    'export' => false,

                ],
            ],

        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',

        ],
        'DefaultTheme' => [
            'class' => 'app\extensions\DefaultTheme\Module',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            //при разработке лучше работать без кеша. НИже отключает кеш - отправляет кеш в пустоту
            //'class' => 'yii\caching\DummyCache',
        ],
        'request' => [
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'njandsfkasbf',
        ],
        'response' => [
            'class' => 'app\components\Response',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login/<service:google_oauth|facebook|etc>' => 'user/user/login',
                'login' => 'user/user/login',
                'logout' => 'user/user/logout',
                'signup' => 'user/user/signup',
                'cart/payment-result/<id:.+>' => 'cart/payment-result',
                'search' => 'default/search',
                'robots.txt' => 'seo/manage/get-robots',
                [
                    'class' => 'app\modules\page\components\PageRule',
                ],
                [
                    'class' => 'app\components\ObjectRule',
                ],
                'events-beacon' => 'core/events-beacon/index',
            ],
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => require(__DIR__ . '/' . (!YII_DEBUG ? 'assets-prod.php' : 'assets-dev.php')),
            'linkAssets' => YII_DEBUG && stripos(PHP_OS, 'WIN')!==0,
        ],
        'user' => [
            'class' => '\yii\web\User',
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/login'],
        ],
        'authManager' => [
            'class'=>'app\components\CachedDbRbacManager',
            'cache' => 'cache',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
        ],
        'apiServiceClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                // имя клиента прописывается в Callback URI
                'yandexwebmaster' => [
                    'class' => 'yii\authclient\clients\YandexOAuth',
                    'clientId' => '3ba7c6d1cc474483832bbfed8050a8e0',
                    'clientSecret' => '3a3b8b551b7e4c70b05274cf62688784',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'default/error',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'samdark\log\PsrTarget',
                    'logger' => $psrLogger,
                    
                    // It is optional parameter. The message levels that this target is interested in.
                    // The parameter can be an array.
                    'levels' => ['debug', yii\log\Logger::LEVEL_WARNING, Psr\Log\LogLevel::CRITICAL],
                    // It is optional parameter. Default value is false. If you use Yii log buffering, you see buffer write time, and not real timestamp.
                    // If you want write real time to logs, you can set addTimestampToContext as true and use timestamp from log event context.
                    'addTimestampToContext' => true,
                ],
                // ...
            ],
        ],
        /*[
            'traceLevel' => YII_DEBUG ? 6 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],*/
        'filterquery' => [
            'class' => 'app\components\filters\FilterQueryChain',
            'filters' => [
                [
                    'class' => 'app\components\filters\ProductPriceRangeFilter',
                ],
                [
                    'class' => 'app\components\filters\FilterRangeProperty',
                ]
            ]
        ],
        'fs' => [
            'class' => '\creocoder\flysystem\LocalFilesystem',
            'path' => '@webroot/files',
        ],
        'session' => [
            'timeout' => 24*3600*30, // 30 days
            'useCookies' => true,
            'cookieParams' => [
                'lifetime' => 24*3600*30,
            ],
        ],
        'view' => [
            'class' => 'app\components\WebView',
            'viewElementsGathener' => 'viewElementsGathener',
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@webroot/theme/views',
                ],
                'baseUrl' => '@webroot/theme/views',
            ],
        ],
        'viewElementsGathener' => [
            'class' => 'app\components\ViewElementsGathener',
        ],
        'subdomainService' => [
            'class' => 'app\components\SubdomainService',
        ],
    ],
];

$allConfig = ArrayHelper::merge(
    file_exists(__DIR__ . '/common.php') ? require(__DIR__ . '/common.php') : [],
    $config,
    file_exists(__DIR__ . '/../web/theme/module/config/common.php')
        ? require(__DIR__ . '/../web/theme/module/config/common.php')
        : [],

    file_exists(__DIR__ . '/common-configurables.php')
        ? require(__DIR__ . '/common-configurables.php')
        : [],

    file_exists(__DIR__ . '/../web/theme/module/config/web.php')
        ? require(__DIR__ . '/../web/theme/module/config/web.php')
        : [],

    file_exists(__DIR__ . '/web-configurables.php')
        ? require(__DIR__ . '/web-configurables.php')
        : [],


    file_exists(__DIR__ . '/common-local.php') ? require(__DIR__ . '/common-local.php') : [],
    file_exists(__DIR__ . '/web-local.php') ? require(__DIR__ . '/web-local.php') : []
);


if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $allConfig['bootstrap'][] = 'debug';
    $allConfig['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'panels' => [],
        'allowedIPs' => ['*'],
    ];
    $allConfig['modules']['gii'] = 'yii\gii\Module';
}


return $allConfig;
