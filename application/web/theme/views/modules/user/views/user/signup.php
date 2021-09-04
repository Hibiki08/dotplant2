<?php

/**
 * @var $model \app\modules\user\models\RegistrationForm
 * @var $this \yii\web\View
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;

//$this->title = Yii::t('app', 'Signup');
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container p-0">
    <div class="row">
        <div class="col-12">
        <?php
            $form = ActiveForm::begin([
                'id' => 'register-form',
                'type' => ActiveForm::TYPE_VERTICAL,
                'action' => '/signup',
            ]);
        ?>
        <div class="user-modal__form">
            <div class="user-modal__form-header"><h2>Регистрация</h2></div>

            <?= $form->field($model, 'username', ['options' => ['class' => 'user-modal__form-item']])
                ->textInput(['autocomplete' => 'off', 'class' => 'input-text']) ?>

            <?= $form->field($model, 'email', ['options' => ['class' => 'user-modal__form-item']])
                ->textInput(['autocomplete' => 'off', 'class' => 'input-text']) ?>
        
            <?= $form->field($model, 'password', ['options' => ['class' => 'user-modal__form-item']])
                ->passwordInput(['class' => 'input-text']) ?>
        
            <?= $form->field($model, 'confirmPassword', ['options' => ['class' => 'user-modal__form-item']])
                ->passwordInput(['class' => 'input-text']) ?>

        </div>

        <?php //TODO Нужно включить в существующую модель формы регистрации?>
        <label class="chk-container user-modal__form-tooltip">Согласен(на) с условиями <a href="#"><span class="colored dotted">публичной оферты</span></a>
                <input type="checkbox" checked="checked">
                <span class="chk-mark"></span>
        </label>
        <?php //TODO end Нужно включить в существующую модель формы регистрации?>

        <div class="user-modal__form-tooltip">
            <a data-fancybox data-src="#login-modal" href="javascript:;">
                <span class="colored">«</span> 
                Назад к форме входа в личный кабинет
            </a>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'form-button']) ?>
        </div>
        
        <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>