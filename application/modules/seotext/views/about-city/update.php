<?php

use app\backend\widgets\BackendWidget;
use app\components\Helper;
use app\models\SeoCityVar;
use app\models\Country;
use kartik\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use yii\web\View;
use yii\web\JsExpression;

/**
 * @var View $this
 * @var SeoCityVar $model
 */

$this->title = $model->isNewRecord ?
    Yii::t('app', 'Create') :
    Yii::t('app', 'Update');
    
$this->params['breadcrumbs'][] = [
    'url' => ['/seotext'],
    'label' => Yii::t('app', 'Сео тексты'),
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Текст о городе'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('submit'); ?>
<div class="form-group no-margin">
    <?= Html::a(
        Icon::show('arrow-circle-left') . Yii::t('app', 'Back'),
        Yii::$app->request->get('returnUrl', ['/seotext/about-city/index']),
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
                'title' => Yii::t('app', 'SeoCityVar'),
                'footer' => $this->blocks['submit'],
            ]); ?>

            <?= $form->field($model, 'city_id')->widget(
                \kartik\select2\Select2::class,
                [
                    'data' => ($model->city ? [$model->city->id => $model->city->name] : []),
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

            <?= $form->field($model, 'text')->textArea(['rows' => 8]) ?>

            <?php BackendWidget::end(); ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
