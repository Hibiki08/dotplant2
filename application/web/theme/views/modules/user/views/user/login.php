<?php
use yii\helpers\Html;
use \kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\LoginForm */

//$this->title = Yii::t('app', 'Login');
//$this->params['breadcrumbs'][] = $this->title;

$isFavorite = $isFavorite ?? false;

?>
<div class="container p-0">
    <div class="row">
        <div class="col-12">

            <?php $form = ActiveForm::begin(['id' => 'login-form', 'action' => '/login']); ?>

            <div class="user-modal__form">

                <?php if($isFavorite) : ?>

                    <div class="user-modal__form-header is_favorite ">
                        <div class="is_favorite_inner">
                            Для добавления в избранное необходимо войти или 
                            <a data-fancybox data-src="#register-modal" href="javascript:;">
                                <span class="colored dotted">зарегистрироваться</span>
                            </a>
                        </div>
                    </div>

                <?php endif; ?>

                <div class="user-modal__form-header <?= ($isFavorite ? 'is_favorite mt-3' : '') ?>">
                    <h2>Войти в личный кабинет</h2>
                </div>


                <?= $form->field($model, 'username', ['options' => ['class' => 'user-modal__form-item']])->textInput(['class' => 'input-text']) ?>

                <?= $form->field($model, 'password', ['options' => ['class' => 'user-modal__form-item']])->passwordInput(['class' => 'input-text']) ?>

                <?= $form->field($model, 'rememberMe')
                    ->checkbox([
                        'label'=>'<span class="chk-mark"></span>Запомнить меня',
                        'labelOptions' => ['class' => 'chk-container'],
                    ]) ?>
                
                <div class="user-modal__form-tooltip">
                    Если Вы забыли пароль, то можете
                    <a data-fancybox data-src="#reset-password-modal" href="javascript:;">
                        <span class="colored dotted">сбросить</span>
                    </a>
                    его
                </div>

                <div
                    class="d-flex justify-content-lg-around justify-content-sm-around justify-content-xs-between justify-content-between align-items-center">
                    <?= Html::submitButton(Yii::t('app', 'Войти'), ['class' => 'form-button']) ?>
                    <?php
                    /* todo заменить на языковые переменные
                        Html::submitButton(Yii::t('app', 'Login'), ['class' => 'form-button'])
                    */
                    ?>
                    <a data-fancybox data-src="#register-modal" href="javascript:;">
                        <div class="form-button">Регистрация</div>
                    </a>
                </div>

            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>