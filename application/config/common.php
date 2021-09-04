<?php

$aliases = \yii\helpers\ArrayHelper::merge(
    [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        'config' => __DIR__,
    ],
    \yii\helpers\ArrayHelper::merge(
        file_exists(__DIR__ . '/aliases.php') ? (array)require(__DIR__ . '/aliases.php') : [],
        file_exists(__DIR__ . '/aliases-local.php') ? (array)require(__DIR__ . '/aliases-local.php') : []
    )
);

$db = require(__DIR__ . '/db.php');
$params = require(__DIR__ . '/params.php');

return [
    'timeZone' => 'Europe/Moscow',
    'bootstrap' => [
        'mail',
        'event'
    ],
    'modules' => [
        'data' => [
            'class' => 'app\data\Module',
            'layout' => '@app/backend/views/layouts/main',
        ],
        'config' => [
            'class' => 'app\modules\config\ConfigModule',
        ],
        'core' => [
            'class' => 'app\modules\core\CoreModule',
        ],
        'image' => [
            'class' => 'app\modules\image\ImageModule',
        ],
        'event' => [
            'class' => 'app\modules\event\EventModule'
        ]
    ],
    'components' => [
        'db' => $db,
        'formatter' => [
            'class' => 'app\components\Formatter',
        ],
        'updateHelper' => [
            'class' => 'app\modules\core\helpers\UpdateHelper',
        ],
        'mail' => [
            'class' => '\app\modules\core\components\MailComponent',
        ],
    ],
    'params' => $params,
    'controllerMap' => [
        'stubs' => [
            'class' => 'bazilio\stubsgenerator\StubsController',
        ],
    ],
    'aliases' => $aliases,
];
