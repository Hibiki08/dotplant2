<?php

use app\backend\components\Helper;
use app\models\City;
use app\models\Subdomain;
use kartik\select2\Select2;
use yii\helpers\Html;
use kartik\dynagrid\DynaGrid;
use app\backend\components\ActionColumn;
use kartik\icons\Icon;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\components\SearchModel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contacts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <?= DynaGrid::widget(
        [
            'options' => [
                'id' => 'contact-grid',
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
                            '/backend/contact/update',
                            'returnUrl' => Helper::getReturnUrl()
                        ],
                        ['class' => 'btn btn-success']
                    ),
                ],
            ],
            'columns' => [
                'id',
                'phone_number',
                'support_phone_number',
                'address',
                'email',
                [
                    'attribute' => 'city_id',
                    'value' => function ($model) {
                        return $model->city ? $model->city->name : null;
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'city_id',
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 3,
                            'ajax' => [
                                'url' => Url::to(['/backend/city/ajax-list']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(item) { return item.text; }'),
                            'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                        ],
                    ])
                ],
                [
                    'attribute' => 'subdomain_id',
                    'value' => function ($model) {
                        return $model->subdomain ? "{$model->subdomain->title} ({$model->subdomain->domain_prefix})" : null;
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'subdomain_id',
                        'options' => ['placeholder' => ''],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 3,
                            'ajax' => [
                                'url' => Url::to(['/backend/subdomain/ajax-list']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(item) { return item.text; }'),
                            'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                        ],
                    ])
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
