<?php

use app\components\Helper;
use app\models\City;
use app\models\Country;
use app\modules\shop\models\UserAddress;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\web\View;
use kartik\select2\Select2;

/**
 * @var UserAddress $model
 * @var $this View
 */

?>
<?php $form = ActiveForm::begin([]); ?>
<div class="delivery-address__wrapper">
    <div class="delivery-address__new">
        <div class="user-profile__form">
            <?= $form->field($model, 'name', ['options' => ['class' => 'user-profile__form-item']])
                ->textInput(['class' => 'input-text']); ?>
            <?= $form->field($model, 'default', ['options' => ['class' => 'user-profile__form-item']])
                ->dropDownList(
                    [0 => Yii::t('app','No'),1 => Yii::t('app','Yes'),],
                    ['class' => 'input-text']
                );; ?>
            <?= $form->field($model, 'country_id', ['options' => ['class' => 'user-profile__form-item']])
                ->widget(Select2::className(), [
                    'data' => Helper::getModelMap(Country::className(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Выберите страну',
                        'class' => 'input-text country_id-field',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            <?= $form->field($model, 'city_id', ['options' => ['class' => 'user-profile__form-item']])
                ->widget(Select2::className(), [
                    'data' => Helper::getModelMap(City::className(), 'id', 'name'),
                    'options' => [
                        'class' => 'input-text city_id-field',
                    ],
                    'pluginOptions' => [
                        'placeholder' => 'Выберите город',
                        'allowClear' => true,
                    ],
                ]); ?>
            <?= $form->field($model, 'zip_code', ['options' => ['class' => 'user-profile__form-item']])
                ->textInput(['class' => 'input-text']); ?>
            <?= $form->field($model, 'address', ['options' => ['class' => 'user-profile__form-item']])
                ->textarea(['class' => 'input-text']); ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Save'), ['class' => 'btn btn-success form-button']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
