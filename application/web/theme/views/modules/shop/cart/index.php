<?php
/**
 * @var \app\modules\shop\models\Order $model
 * @var \app\modules\shop\models\OrderCode $orderCode
 * @var \yii\web\View $this
 */
use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

$this->context->layout = '@app/web/theme/views/modules/basic/layouts/simple';

$this->title = Yii::t('app', 'Корзина'); 

$mainCurrency = \app\modules\shop\models\Currency::getMainCurrency();

?>

<div class="page__wrapper fade">
    <div class="page__title text-xl-left text-sm-center text-center fade">
        <i class="fas fa-shopping-cart"></i>
        <h1><?= Yii::t('app', 'Корзина') ?>
    </div>

    <?php if (!is_null($model) && $model->items_count > 0): ?>
    
        <div id="cart-table"  class="container p-0 fade">
            <?= $this->render('items_new', ['model' => $model, 'items' => $model->items, 'mainCurrency' => $mainCurrency,]) ?>

            <?php /*
            <tr>
                <td colspan="3"></td>
                <td><strong><span class="items-count"><?= $model->items_count ?></span></strong></td>
                <td>
                    <span class="label label-info">
                        <span class="total-price ">
                            <?= $mainCurrency->format($model->total_price) ?>
                        </span>

                    </span>
                </td>
            </tr>
            */ ?>

            <div class="shop-cart__total d-flex align-items-center justify-content-between flex-lg-row flex-md-column flex-column">
                <div class="shop-cart__coupon">
                    <?php if ($orderCode->isNewRecord): ?>
                        <?php $form = ActiveForm::begin(['options' => ['class' => 'shop-cart__form-item flex-lg-row flex-md-row flex-column']]) ?>
                            
                            <?= $form->field($orderCode, 'code', ['template' => "<i class='fas fa-tag'></i>{label}\n{hint}\n{input}\n{error}", 'options' => ['tag' => false]])
                                ->textInput(['class' => 'input-text']) ?>
                            
                            <?= Html::submitButton(Yii::t('app', 'Применить'), ['class' => 'shop-cart__form-button']); ?>

                            <?= $form->errorSummary($orderCode) ?>

                        <?php ActiveForm::end() ?>
                    <?php else: ?>
                        <?= Yii::t('app', 'Applied discount code:') ?>
                        <div class="applied-discount-code">
                            <?= $orderCode->discountCode->code ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="shop-cart__total-sum"><span>Итого: </span><strong class="total-price"><?= $mainCurrency->format($model->total_price) ?></strong></div>
            </div>

            <div class="shop-cart__total-checkout d-flex align-items-center justify-content-between flex-lg-row flex-md-row flex-column">
                <div class="shop-cart__total-checkout-go-back">
                    <a href="/catalog"><div class="shop-cart__form-button continue">Продолжить покупки</div></a>
                </div>
                <div class="shop-cart__total-checkout-button">
                    <?php //if($model->stage->isInitial()) :?>
                        <?= Html::a(Yii::t('app', '<div class="shop-cart__form-button checkout">Оформить заказ <i class="fas fa-check ml-2"></i></div>'), 
                            ($model->stage->isInitial() ? ['/shop/cart/stage'] : ['/shop/cart/stage-leaf', 'id' => 1]), 
                            ['class' => '']); ?>
                    <?php //endif;?>
                </div>
            </div>
        </div>

        <div class="container d-flex align-items-center justify-content-around">
            <div class="step-container">
                <div class="step active">
                    <div class="step-icon">1</div>
                    <div class="step-text"><span>Корзина</span></div>
                </div>
                <div class="line"></div>
                <div class="step">
                    <div class="step-icon">2</div>
                    <div class="step-text"><span>Доставка</span></div>
                </div>
                <div class="line"></div>
                <div class="step">
                    <div class="step-icon">3</div>
                    <div class="step-text"><span>Оплата</span></div>
                </div>
                <div class="line"></div>
                <div class="step">
                    <div class="step-icon">4</div>
                    <div class="step-text"><span>Готово</span></div>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="container p-0 fade">
            <p><?= Yii::t('app', 'Ваша корзина пуста') ?></p>
            <?php
            // todo вернуть перевод
            // <p><?= Yii::t('app', 'Your cart is empty') ></p>
            ?>

            <div class="shop-cart__total-checkout-go-back">
                <a href="/catalog"><div class="shop-cart__form-button continue">Продолжить покупки</div></a>
            </div>

        </div>

    <?php endif; ?>
</div>