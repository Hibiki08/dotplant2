<?php

use app\backend\widgets\BackendWidget;
use app\models\Contact;
use kartik\helpers\Html;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 * @var Contact $model
 */

$this->title = $model->isNewRecord ?
    Yii::t('app', 'Create') :
    Yii::t('app', 'Update');

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Contacts'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('submit'); ?>
<div class="form-group no-margin">
    <?= Html::a(
        Icon::show('arrow-circle-left') . Yii::t('app', 'Back'),
        Yii::$app->request->get('returnUrl', ['/backend/city/index']),
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
                'title' => Yii::t('app', 'Contact'),
                'footer' => $this->blocks['submit'],
            ]); ?>

            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'support_phone_number')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => 50]) ?>

            <?php $cityData = $model->city ? [$model->city->id => $model->city->name] : [] ?>
            <?= $form->field($model, 'city_id')->widget(
                \kartik\select2\Select2::class,
                [
                    'data' => $cityData,
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
                ]
            ) ?>

            <?php
            $subdomainData = $model->subdomain
                ? [$model->subdomain->id => "{$model->subdomain->title} ({$model->subdomain->domain_prefix})" ]
                : []
            ?>
            <?= $form->field($model, 'subdomain_id')->widget(
                \kartik\select2\Select2::class,
                [
                    'data' => $subdomainData,
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
                ]
            ) ?>

            <h4><?= Yii::t('app', 'Map') ?></h4><br>

            <?= $form->field($model, 'map_longitude')->textInput(['maxlength' => 20]) ?>
            <?= $form->field($model, 'map_latitude')->textInput(['maxlength' => 20]) ?>
            <?= $form->field($model, 'map_zoom')->textInput() ?>

            <?php BackendWidget::end(); ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
