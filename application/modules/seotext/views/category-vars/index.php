<?php

use app\backend\components\Helper;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use app\backend\components\ActionColumn;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $searchModel app\components\SearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Выражения для Seo-текстов для связки с категориями');
$this->params['breadcrumbs'][] = [
    'url' => ['/seotext'],
    'label' => Yii::t('app', 'Сео тексты'),
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sv-index">

    <?=
    DynaGrid::widget(
        [
            'options' => [
                'id' => 'sv-grid',
            ],
            'theme' => 'panel-default',
            'gridOptions' => [
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'hover' => true,
                'panel' => [
                    'heading' => Html::tag('h3', $this->title, ['class' => 'panel-title']),
                    'after' => Html::a(
                        Icon::show('plus') . Yii::t('app', 'Add'),
                        [
                            '/seotext/category-vars/update',
                            'returnUrl' => Helper::getReturnUrl()
                        ],
                        ['class' => 'btn btn-success']
                    ),
                ],
            ],
            'columns' => [
                'id',
                'word',
                'example',
                'description',
                [
                    'class' => ActionColumn::className(),
                    'buttons' => [
                        [
                            'url' => 'update',
                            'icon' => 'pencil',
                            'class' => 'btn-primary',
                            'label' => Yii::t('app', 'Edit'),
                        ],
                        [
                            'url' => 'delete',
                            'icon' => 'trash-o',
                            'class' => 'btn-danger',
                            'label' => Yii::t('app', 'Delete'),
                            'options' => [
                                'data-action' => 'delete',
                            ],
                        ],
                    ],
                ],
            ],
        ]
    );
    ?>

</div>
