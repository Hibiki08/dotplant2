<?php

use yii\widgets\DetailView;

/**
 * @var \app\modules\shop\models\UserAddress $model
 */

$this->title = Yii::t('app', 'Адрес') . ': ' . $model->name;
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
        <br>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                [
                    'attribute' => 'default',
                    'value' => $model->default == 1 ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
                ],
                [
                    'attribute' => 'country_id',
                    'value' => $model->country ? $model->country->name : '',
                ],
                [
                    'attribute' => 'city_id',
                    'value' => $model->city ? $model->city->name : '',
                ],
                'zip_code',
                'address'
            ]
        ]); ?>
    </div>
</div>

