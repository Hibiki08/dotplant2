<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


$this->title = Yii::t('app', 'Скачать новый файл для импорта');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

<div class="list-group">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput()->hint('Введите ссылку на файл CSV'); ?>

    <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end();  ?>
</div>