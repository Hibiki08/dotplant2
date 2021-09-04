<?php

use app\backend\widgets\BackendWidget;
use app\components\Helper;
use app\models\SeoCategoryVar;
use app\models\Country;
use kartik\helpers\Html;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use yii\web\View;

/**
 * @var View $this
 * @var SeoCategoryVar $model
 */

$this->title =  Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = [
    'url' => ['/seotext'],
    'label' => Yii::t('app', 'Сео тексты'),
];
$this->params['breadcrumbs'][] = [
    'label' =>Yii::t('app', 'Seo значения для городов'),
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
                'title' => Yii::t('app', 'SeoCategoryVar'),
                'footer' => $this->blocks['submit'],
            ]); ?>
            <table class="table table-bordered table-condensed table-hover table-responsive">
                <thead>
                    <tr>
                        <td colspan="3">
                            <h3>город <?= $category->name ?></h3>
                        </td>
                    </tr>
                    <tr>
                        <td width="150px">
                            Выражение для замены
                        </td>
                        <td width="150px">
                            Пример
                        </td>
                        <td>
                            Значение для данного города
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($models as $i => $model): ?>
                        <tr>
                            <td>
                                {<?= $model->var->word ?>}
                            </td>
                            <td>
                                <em>*<?= $model->var->example ?></em>
                            </td>
                            <td>
                                <?= $form->field($model, "[$i]seo_variable_id")->hiddenInput()->label(false) ?>
                                <?= $form->field($model, "[$i]category_id")->hiddenInput()->label(false) ?>
                                <?= $form->field($model, "[$i]seo_word")->textInput()->label(false) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php BackendWidget::end(); ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
