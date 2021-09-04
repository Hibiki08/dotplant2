<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


$this->title = Yii::t('app', 'Задать начальные данные для импорта');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

<div class="list-group">
    <?php $form = ActiveForm::begin(['action' => ['import-form', 'categories' => 0]]); ?>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <?php $model = reset($models); ?>
                <th style="width: 15%;">Наименование категории</th>
                <th style="width: 30%;"><?= $model->attributeLabels()['oldPriceOption'] ?></th>
                <th style="width: 10%;"><?= $model->attributeLabels()['oldPriceCoeff'] ?></th>
                <th style="width: 30%;"><?= $model->attributeLabels()['priceOption'] ?></th>
                <th style="width: 10%;"><?= $model->attributeLabels()['priceCoeff'] ?></th>
            </tr>
        </thead>
    
        <tbody>
            <?php foreach ($models as $catId => $model): ?>
                <tr data-level="<?= ($model->parent == 1 ? 0 : 1)?>">
                    <td style="<?= ($model->parent == 1 ? 'font-weight: bold;' : 'padding-left: 30px; text-align: right;') ?>">
                        <?= $model->catName?>
                        <?= $form->field($model, "[$catId]catId")->hiddenInput()->label(false); ?>
                    </td>
                    <td><?= $form->field($model, "[$catId]oldPriceOption")->dropDownList($model->options)->label(false); ?></td>
                    <td><?= $form->field($model, "[$catId]oldPriceCoeff")->label(false); ?></td>
                    <td><?= $form->field($model, "[$catId]priceOption")->dropDownList($model->options)->label(false); ?></td>
                    <td><?= $form->field($model, "[$catId]priceCoeff")->label(false); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>

    <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end();  ?>
</div>