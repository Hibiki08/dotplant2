<?php
/**
 * Use existent form
 * @var \yii\web\View $this
 * @var \app\modules\shop\models\DeliveryInformation $deliveryInformation
 * @var \app\modules\shop\models\OrderDeliveryInformation $orderDeliveryInformation
 * @var boolean $immutable
 * @var string $action
 * @var \yii\bootstrap\ActiveForm $form
 */
?>

    <div class="user-profile__user-order-title"><h2><?= Yii::t('app', 'Delivery information') ?></h2></div>
    
    <?= $form->field($deliveryInformation, 'country_id', ['options' => ['class' => 'user-profile__form-item ']])
        ->dropDownList(
            \app\components\Helper::getModelMap(\app\models\Country::className(), 'id', 'name'),
            ['readonly' => $immutable, 'class' => 'input-text', ]
    ); ?>
    <?= $form->field($deliveryInformation, 'city_id', ['options' => ['class' => 'user-profile__form-item ']])
        ->dropDownList(
            \app\components\Helper::getModelMap(\app\models\City::className(), 'id', 'name'),
            ['readonly' => $immutable, 'class' => 'input-text', ]
    ); ?>
    <?= $form->field($deliveryInformation, 'zip_code', ['options' => ['class' => 'user-profile__form-item ']])->textInput(['readonly' => $immutable, 'class' => 'input-text', ]); ?>
    <?= $form->field($deliveryInformation, 'address', ['options' => ['class' => 'user-profile__form-item ']])->textarea(['readonly' => $immutable, 'class' => 'input-text', ]); ?>

    <?= $form->field($orderDeliveryInformation, 'shipping_option_id', ['options' => ['class' => 'user-profile__form-item ']])
        ->dropDownList(
            \app\components\Helper::getModelMap(\app\modules\shop\models\ShippingOption::className(), 'id', 'description'),
            //todo  bug пустое поле выбора
            ['readonly' => $immutable, 'class' => 'input-text', ]
    )->label('Способ доставки'); ?>

    <?php
        /** @var \app\properties\AbstractModel $abstractModel */
        $abstractModel = $orderDeliveryInformation->getAbstractModel();
        $abstractModel->setArrayMode(false);
        foreach ($abstractModel->attributes() as $attr) {
            echo $form->field($abstractModel, $attr, ['options' => ['class' => 'user-profile__form-item ']])
                ->textInput(['readonly' => $immutable, 'class' => 'input-text']);
        }
    ?>

