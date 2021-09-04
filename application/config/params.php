<?php

use yii\helpers\ArrayHelper;

$params = [
    'adminEmail' => 'tehdir@skobeeff.ru',
    'icon-framework' => 'fa',
    'rbacType' => [
        \yii\rbac\Item::TYPE_PERMISSION => 'Permission',
        \yii\rbac\Item::TYPE_ROLE => 'Role',
    ],
    'currency' => '<del>Р</del>',

    /**
     * https://confluence.cdek.ru/pages/viewpage.action?pageId=15616129#id-%D0%9F%D1%80%D0%BE%D1%82%D0%BE%D0%BA%D0%BE%D0%BB%D0%BE%D0%B1%D0%BC%D0%B5%D0%BD%D0%B0%D0%B4%D0%B0%D0%BD%D0%BD%D1%8B%D0%BC%D0%B8(v1.5)-TestAccount1.5.%D0%A2%D0%B5%D1%81%D1%82%D0%BE%D0%B2%D1%8B%D0%B5%D1%83%D1%87%D0%B5%D1%82%D0%BD%D1%8B%D0%B5%D0%B7%D0%B0%D0%BF%D0%B8%D1%81%D0%B8%D0%B8%D0%B8%D1%85%D0%BE%D0%B3%D1%80%D0%B0%D0%BD%D0%B8%D1%87%D0%B5%D0%BD%D0%B8%D1%8F
     * Тестовые учетные записи для расчета доставки
     * На боевом сервере заменить на реальные данные
     * Используется APi1.5
     */
    'sdek' => [
        'shopAccount' => 'un2ISrngpzk7XiNTgyddPwB5O8hiWk51',
        'shopPassword' => 'Ct6hpdwY0YOQe04vodoMxioGxTtVvxAV',
        'deliveryAccount' => 'un2ISrngpzk7XiNTgyddPwB5O8hiWk51',
        'deliveryPassword' => 'Ct6hpdwY0YOQe04vodoMxioGxTtVvxAV',
    ],

    'importUrl' => 'http://feed.p5s.ru/data/5ff90cb3726e67.20069056',
];

return ArrayHelper::merge(
    $params,
    file_exists(__DIR__ . '/params-local.php') ? require(__DIR__ . '/params-local.php') : [],
    file_exists(__DIR__ . '/../web/theme/module/config/params.php')
    ? require(__DIR__ . '/../web/theme/module/config/params.php')
    : []
);
