<?php

/**
 * @var $model \app\modules\user\models\User
 * @var $propertyGroups \app\models\PropertyGroup[]
 * @var $services array
 * @var $this yii\web\View
 */

use \yii\widgets\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use app\modules\user\models\User;

$this->title = Yii::t('app', 'Контактные данные');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Личный кабинет'),
        'url' => ['/user/user/profile']
    ],
    $this->title,
];

$propertyGroups = $model->getPropertyGroups();

$form = ActiveForm::begin([
    'id' => 'profile-form',
    'fieldConfig' => [
        'options' => [
            'tag' => false,
        ]
    ]
]);
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
                            <div class="user-profile__form-item">
                                <?= $form->field($model, 'first_name')
                                    ->textInput(['class' =>'input-text',])
                                    ->label('Ваше имя:') ?>
                            </div>
                            <div class="user-profile__form-item">
                                <?= $form->field($model, 'last_name')
                                    ->textInput(['class' =>'input-text',])
                                    ->label('Ваша фамилия:')  ?>
                            </div>
                            <div class="user-profile__form-item">
                                <?= $form->field($model, 'phone')
                                    ->textInput(['class' =>'input-text',])
                                    ->label('Телефон:') ?>
                            </div>
                            <div class="user-profile__form-item">
                                <?= $form->field($model, 'email')
                                    ->input('email', ['class' =>'input-text',])
                                    ->label('E-mail:') ?>
                            </div>
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

            <div class="mt-3"> <span class="colored dotted">
            <?=
            Html::a(
                Yii::t('app', 'сменить пароль'),
                ['/user/user/change-password'], ['class' => 'save-button']
            )
            ?>
            </span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <?php
        $authChoice = AuthChoice::begin([
            'baseAuthUrl' => ['/user/user/auth']
        ]);
        ?>
        <?php if (count($authChoice->clients) > count($services)): ?>
            <h3><?= Yii::t('app', 'Attach service') ?></h3>
            <ul class="auth-clients clear">
                <?php foreach ($authChoice->clients as $client): ?>
                    <?php if (!in_array($client->className(), $services)): ?>
                        <li class="auth-client"><?= $authChoice->clientLink($client) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php AuthChoice::end(); ?>
        <?php if (!empty($services)): ?>
            <h3><?= Yii::t('app', 'Detach service') ?></h3>
            <?php
            $authChoice = AuthChoice::begin([
                'baseAuthUrl' => ['/user/user/auth']
            ]);
            ?>
            <ul class="auth-clients clear">
                <?php foreach ($authChoice->clients as $client): ?>
                    <?php if (in_array($client->className(), $services)): ?>
                        <li class="auth-client"><?= $authChoice->clientLink($client) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <?php AuthChoice::end(); ?>
        <?php endif; ?>
    </div>
</div>

<?php ActiveForm::end(); ?>