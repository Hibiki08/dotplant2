<?php
/**
 * @var \yii\web\View $this
 * @var \yii\bootstrap\ActiveForm $form
 * @var \app\modules\shop\models\DeliveryInformation $deliveryInformation
 * @var \app\modules\shop\models\OrderDeliveryInformation|\app\properties\HasProperties $orderDeliveryInformation
 * @var \app\properties\AbstractModel $abstractModel
 * @var \app\modules\shop\models\UserAddress[] $userAddresses
 * @var \app\modules\shop\models\UserAddress $userAddress
 */

use app\components\Helper;
use app\models\City;
use app\models\Country;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


$deliveryInformation->isPickup = ($orderDeliveryInformation->shipping_option_id == 2 ? 1 : 0);
?>
<div class="container p-0 fade js__delivery">
    <div class="delivery-type">

        <div class='js__curier_select delivery-type-select <?= ($orderDeliveryInformation->shipping_option_id == 1 ? 'selected' : '' ) ?>' data-value="1">
            <img src="/theme/dist/img/icons/delivery-man.svg" alt="Курьером">
            <div class="title">Курьером</div>
            <div class="subtitle"><i class="far fa-clock"></i> в рабочие дни</div>
            
            <div class="js__delivery_info js__curier">
                <?php if($deliveryInformation->city): ?>
                <?= $this->render('_deliveryPrice', ['orderDeliveryInformation' => $orderDeliveryInformation, 'cityCode' => $deliveryInformation->city->cdek_code, 'isPickup' => false,]) ?>
                <?php endif;?>
            </div>
        </div>

        <div class='js__pickup_select delivery-type-select <?= ($orderDeliveryInformation->shipping_option_id == 2 ? 'selected' : '' ) ?>' data-value="2">
            <img src="/theme/dist/img/icons/warehouse.svg" alt="Самовывоз">
            <div class="title">Самовывоз</div>
            <div class="subtitle"><i class="far fa-clock"></i> в часы работы пунктов самовывоза</div>
            
            <div class="js__delivery_info js__pickup">
                <?php if($deliveryInformation->city): ?>
                <?= $this->render('_deliveryPrice', ['orderDeliveryInformation' => $orderDeliveryInformation, 'cityCode' => $deliveryInformation->city->cdek_code, 'isPickup' => true,]) ?>
                <?php endif;?>
            </div>
        </div>

        <?php /*
        <div class='delivery-type-select <?= ($orderDeliveryInformation->shipping_option_id == 3 ? 'selected' : '' ) ?>' data-value="3">
            <img src="/theme/dist/img/icons/post-box.svg" alt="Почтой">
            <div class="title">Почтой</div>
            <div class="subtitle"><i class="far fa-clock"></i> в течении 1-2 недель</div>
        </div>
        */ ?>
    </div>  

    <?= $form->field($orderDeliveryInformation, 'shipping_option_id',['options' => ['class' => 'error-block font-weight-bolder text-danger text-center']])
            ->hiddenInput(['id' => 'delivery-type',])
            ->label(false); ?>

    <div class="delivery-address__wrapper">
        <div class="page__title text-xl-left text-sm-center text-center fade">
            <h2><i class="fas fa-home"></i> Адрес доставки</h2>
        </div>

        <div class="delivery-address__new">
            <div class="user-profile__form" style="position: relative">

                <?php if (!\Yii::$app->user->isGuest) { ?>
                    <?= $form->field($userAddress, 'id', [
                            'options' => [
                                'id' => 'user-addresses-list',
                                'class' => 'user-profile__form-item'
                            ]
                        ])
                        ->dropDownList(
                            ArrayHelper::merge(
                                [
                                    'not_save' => '-- Разовый адрес',
                                    'new' => '-- Новый адрес',
                                ],
                                ArrayHelper::map($userAddresses, 'id', 'name')
                            ),
                            [
                                'class' => 'input-text',
                            ]
                        )
                        ->label('Ваши адреса'); ?>

                <?php $userAddress->name = '' ?>
                <?= $form->field($userAddress, 'name', ['options' => [
                        'style' => 'display:none',
                        'class' => 'user-profile__form-item name-field',
                    ]])
                    ->label('Новый адрес')
                    ->textInput(['class' => 'input-text']);?>
            <?php } ?>

            <?= $form->field($deliveryInformation, 'isPickup')
                ->hiddenInput(['id' => 'isPickup'])->label(false); ?>

            <?= $form->field($deliveryInformation, 'country_id', ['options' => ['class' => 'user-profile__form-item']])
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

            <?= $form->field($deliveryInformation, 'city_id', ['options' => ['class' => 'user-profile__form-item']])
                ->textInput()
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

            <?= $form->field($deliveryInformation, 'zip_code', ['options' => ['class' => 'user-profile__form-item']])
                ->textInput(['class' => 'input-text zip_code-field']); ?>

            <?= $form->field($deliveryInformation, 'address', [
                    'options' => [
                        'id' => 'address-field', 
                        'class' => 'user-profile__form-item',
                        'style' => ($orderDeliveryInformation->shipping_option_id == 2 ? 'display:none' : ''),
                    ],
                ])
                ->textarea(['id' => 'address-input', 'class' => 'input-text address-field']); ?>

            <?php
                $abstractModel = $orderDeliveryInformation->getAbstractModel();
                $abstractModel->setArrayMode(false);
                foreach ($abstractModel->attributes() as $attr) {
                    echo $form->field($abstractModel, $attr);
                }
            ?>
            <div class="overload" style="display: none; position: absolute; top: 0;left: 0;width: 100%; height: 100%;opacity: 0.5;background-color: white;"></div>
        </div>
    </div>

</div>
<?php
$js = <<<JS
    $(document).ready(function () {
        $('#user-addresses-list')
            .on('change', function() {
                let fieldsBox = $('.user-profile__form'),
                    overload = fieldsBox.find('.overload'),
                    nameField = fieldsBox.find('.name-field'),
                    country = fieldsBox.find('.country_id-field'),
                    city = fieldsBox.find('.city_id-field'),
                    zip = fieldsBox.find('.zip_code-field'),
                    address = fieldsBox.find('.address-field'),
                    selectedValue = $(this).find('option:selected').val();

                if (selectedValue !== 'new') {
                    nameField.css('display', 'none');
                    nameField.find('[name *= name]').prop('disabled', 'disabled');
                } else {
                    nameField.css('display', 'block');
                    nameField.find('[name *= name]').prop('disabled', false);
                }
                
                if (selectedValue === 'new' || selectedValue === 'not_save') {
                    country.prop('disabled', false);
                    city.prop('disabled', false);
                    zip.prop('disabled', false);
                    address.prop('disabled', false);
                    
                    return;
                }
                    
                overload.css('display', 'block');
                $.get(
                    '/shop/address/view',
                    {id: selectedValue},
                    function (answer) { 
                        if (answer.country_id > 0) {
                            country.val(answer.country_id).prop('disabled', 'disabled');
                        }
                        
                        if (answer.city_id > 0) {
                            city.val(answer.city_id).prop('disabled', 'disabled');
                        }
                        
                        if (answer.zip_code) {
                            zip.val(answer.zip_code).prop('disabled', 'disabled');
                        }
                        
                        if (answer.address) {
                            address.val(answer.address).prop('disabled', 'disabled');
                        }
                    },
                    'json'
                ).complete(function(){overload.css('display', 'none');});
            })
            .trigger('change');
    });
JS;
$this->registerJs($js);
