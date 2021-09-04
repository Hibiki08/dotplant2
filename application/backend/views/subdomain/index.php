<?php

use app\backend\components\Helper;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use app\backend\components\ActionColumn;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $searchModel app\components\SearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Subdomain');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdomain-index">

    <?=
    DynaGrid::widget(
        [
            'options' => [
                'id' => 'subdomain-grid',
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
                            '/backend/subdomain/update',
                            'returnUrl' => Helper::getReturnUrl()
                        ],
                        ['class' => 'btn btn-success']
                    ),
                ],
            ],
            'columns' => [
                'id',
                'title',
                'domain_prefix',
                [
                    'attribute' => 'is_stock',
                    'value' => function ($model) {
                        return Yii::$app->formatter->asBoolean($model->is_stock);
                    },
                    'filter' => \kartik\select2\Select2::widget([
                        'data' => [
                            1 => Yii::t('yii', 'Yes'),
                            0 => Yii::t('yii', 'No'),
                        ],
                        'model' => $searchModel,
                        'attribute' => 'is_stock',
                        'options' => [
                            'placeholder' => '',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
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
