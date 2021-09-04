<?php

/**
 * @var $model \app\modules\user\models\User
 * @var $this yii\web\View
 */

use kartik\helpers\Html;
use kartik\form\ActiveForm;

$this->title = Yii::t('app', 'Change a password');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Personal cabinet'),
        'url' => '/shop/cabinet'
    ],
    $this->title,
];

?>
<?= \app\widgets\Alert::widget() ?>
        <?php
            $form = ActiveForm::begin(
                [
                    'action' => \yii\helpers\Url::toRoute(['/user/user/change-password']),
                    'id' => 'change-password-form',
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'method' => 'POST',
                ]
            );
        ?>
        <div class="col-lg-12 col-12">
            <div class="container">
                <div class="page__wrapper fade">
                    <div class="page__title text-xl-left text-sm-center text-center fade">
                        <i class="fas fa-user"></i>
                        <h1><?= $this->title ?></h1>
                    </div>
                    <div class="container p-0 fade">
                        <div class="row">
                            <div class="col-lg-7 col-12">
                                <div class="user-profile__form">

                                    <?= $form->field($model, 'password', ['options' => ['class' =>'user-profile__form-item',]])
                                        ->passwordInput(['class' =>'input-text',])
                                        ->label(Yii::t('app', 'Current password')) ?>

                                    <?= $form->field($model, 'newPassword', ['options' => ['class' =>'user-profile__form-item',]])
                                        ->passwordInput(['class' =>'input-text',]) ?>

                                    <?= $form->field($model, 'confirmPassword', ['options' => ['class' =>'user-profile__form-item',]])
                                        ->passwordInput(['class' =>'input-text',]) ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'save-button']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
