<?php

use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var ActiveDataProvider $dataProvider
 * @var $this View
 */

$this->title = Yii::t('app', 'Адреса');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Личный кабинет'),
        'url' => ['/user/user/profile']
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
        <div>
            <a href="<?= \yii\helpers\Url::to('create')?>">Добавить адрес</a>
        </div>
        <br>
        <?= \yii\grid\GridView::widget([
            'columns' => [
                [
                    'attribute' => 'name',
                    'contentOptions' => ['data-label' => Yii::t('app','Name')],
                ],
                [
                    'attribute' => 'default',
                    'label' => Yii::t('app','Default'),
                    'value' => function ($model) {
                        return $model->default == 1 ? Yii::t('app','Yes') : Yii::t('app','No');
                    },
                    'contentOptions' => ['data-label' => Yii::t('app','Default')],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => '',
                    'template' => '{view}<br/>{update}<br/>{delete}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app','View details'), $url, ['class' => 'btn-table-view']);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app','Edit'), $url, ['class' => 'btn-table-view']);
                        },
                        'delete' => function($url, $model, $key) {
                            return Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                    ],
                ],
            ],
            'dataProvider' => $dataProvider,
            'summary' => false,
            'tableOptions' => ['class' => 'user-profile__user-order-table'],
            'options' => ['class' => 'user-profile__wrapper wrapper-table'],
        ]); ?>


    </div>
</div>

