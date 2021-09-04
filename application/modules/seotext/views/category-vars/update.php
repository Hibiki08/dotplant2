<?php

use app\backend\widgets\BackendWidget;
use app\components\Helper;
use app\models\SeoCityVar;
use app\models\Country;
use kartik\helpers\Html;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use yii\web\View;

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
    'label' => Yii::t('app', 'Выражения для Seo-текстов для связки с категориями'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('submit'); ?>
<div class="form-group no-margin">
    <?= Html::a(
        Icon::show('arrow-circle-left') . Yii::t('app', 'Back'),
        Yii::$app->request->get('returnUrl', ['/seotext/vars/index']),
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

            <?= $form->field($model, 'word')->textInput() ?>

            <?= $form->field($model, 'example')->textInput() ?>

            <?= $form->field($model, 'description')->textInput() ?>

            <?php BackendWidget::end(); ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
