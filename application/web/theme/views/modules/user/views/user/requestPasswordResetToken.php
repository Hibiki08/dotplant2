<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\PasswordResetRequestForm */

//$this->title = Yii::t('app', 'Request password reset');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container p-0">
    <div class="row">
        <div class="col-12">
            <?php $form = ActiveForm::begin([
                'id' => 'request-password-reset-form',
                'action' => '/user/user/request-password-reset',
            ]); ?>
            <div class="user-modal__form">
                <div class="user-modal__form-header"><h2>Сбросить пароль</h2></div>
                <div class="user-modal__form-tooltip">Пожалуйста, укажите ваш e-mail, на него придет ссылка для сброса пароля</div>
                <?= $form->field($model, 'email', ['options' => ['class' => 'user-modal__form-item']])
                    ->textInput(['class' => 'input-text']) ?>
            </div>

            <div class="user-modal__form-tooltip">
                <a data-fancybox data-src="#login-modal" href="javascript:;">
                    <span class="colored">«</span> 
                    Назад к форме входа в личный кабинет
                </a>
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <?= Html::submitButton('Сбросить', ['class' => 'form-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
