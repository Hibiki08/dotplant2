<?php

use app\backend\widgets\BackendWidget;
use app\models\Subdomain;
use kartik\helpers\Html;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 * @var Subdomain $model
 */

$this->title = $model->isNewRecord ?
    Yii::t('app', 'Create') :
    Yii::t('app', 'Update');

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Subdomains'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('submit'); ?>
<div class="form-group no-margin">
    <?= Html::a(
        Icon::show('arrow-circle-left') . Yii::t('app', 'Back'),
        Yii::$app->request->get('returnUrl', ['/backend/subdomain/index']),
        ['class' => 'btn btn-danger']
    ) ?>
    <?php if ($model->isNewRecord) { ?>
        <?= Html::submitButton(
            Icon::show('save') . Yii::t('app', 'Save & Go next'),
            [
                'class' => 'btn btn-success',
                'name' => 'action',
                'value' => 'next',
            ]
        ) ?>
    <?php } ?>
    <?= Html::submitButton(
        Icon::show('save') . Yii::t('app', 'Save & Go back'),
        [
            'class' => 'btn btn-warning',
            'name' => 'action',
            'value' => 'back',
        ]
    ) ?>
    <?= Html::submitButton(
        Icon::show('save') . Yii::t('app', 'Save'),
        [
            'class' => 'btn btn-primary',
            'name' => 'action',
            'value' => 'save',
        ]
    ) ?>
</div>
<?php $this->endBlock('submit'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <?php $form = ActiveForm::begin(); ?>

            <?php BackendWidget::begin([
                'icon' => 'tag',
                'title' => Yii::t('app', 'Subdomain'),
                'footer' => $this->blocks['submit'],
            ]); ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'domain_prefix')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'is_stock')->checkbox() ?>

            <?php
            $cityData = count($model->cities) > 0
                ? \yii\helpers\ArrayHelper::map($model->cities, 'id', 'name')
                : []
            ?>
            <?= $form->field($model, 'cities')->widget(
                \kartik\select2\Select2::class,
                [
                    'data' => $cityData,
                    'options' => [
                            'placeholder' => '',
                        'multiple' => true,
                    ],
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
                ]
            ) ?>

            <?php BackendWidget::end(); ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
