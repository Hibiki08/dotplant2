<?php

use app\modules\shop\models\UserAddress;
use yii\web\View;

/**
 * @var UserAddress $model
 * @var string $message
 * @var $this View
 */

$this->title = Yii::t('app', 'Добавление адреса');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Личный кабинет'),
        'url' => ['/user/user/profile']
    ],
    [
        'label' => Yii::t('app', 'Адреса'),
        'url' => ['/shop/address/list']
    ],
    $this->title,
];

?>

<div class="container">
    <div class="category__wrapper fade">
        <div class="category__title d-lg-block text-xl-left text-sm-center text-center">
            <i class="far fas fa-file-alt"></i>
            <h1><?= $this->title ?></h1>
        </div>
        <p><?= $message ?></p>
        <br>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
