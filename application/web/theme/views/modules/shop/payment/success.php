<?php
use yii\helpers\Url;
/**
 * @var \yii\web\View $this
 * @var \app\modules\shop\models\OrderTransaction $transaction
 */
$this->context->layout = '@app/web/theme/views/modules/basic/layouts/simple';
    $this->title = Yii::t('app', 'Заказ оформлен');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="container p-0">
                <div class="page__wrapper fade">
                    <div class="page__title text-xl-left text-sm-center text-center fade"><i class="fas fa-file-alt"></i><h1>Заказ оформлен</h1></div>
                    <div class="container p-0 fade">
                        <div class="shop_cart__payment-success container p-3 text-center">
                           <h2>Спасибо, за ваш выбор!</h2>
                            <p>Инвойс об оплате выслан на ваш e-mail.<br>
                            Посмотреть статус заказа можно 
                            <a href="<?=Url::to([
                                    '/shop/orders/show',
                                    'hash' => $transaction->order->hash
                                ]) ?>">
                                    <?= (!Yii::$app->user->isGuest ? 'в личном кабинете' : 'здесь') ?>
                            </a>.</p>
                        </div>
                    </div>
                    <div class="payment-button container p-0 mt-3 fade">
                        <div class="shop-cart__verify-button d-flex flex-column justify-content-md-arround justify-content-sm-center justify-content-center align-items-center p-3">
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <a href="<?=Url::to('/shop/cabinet') ?>">
                                    <div class="shop-cart__form-button">В личный кабинет</div>
                                </a>
                            <?php else:?>
                                <a href="/catalog">
                                    <div class="shop-cart__form-button continue">Продолжить покупки</div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="container d-flex align-items-center justify-content-around fade">
                        <div class="step-container">
                            <div class="step done">
                                <div class="step-icon"><svg viewBox="0 0 16 16"><polyline fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg></div>
                                <div class="step-text"><span>Корзина</span></div>
                            </div>
                            <div class="line done"></div>
                            <div class="step done">
                                <div class="step-icon"><svg viewBox="0 0 16 16"><polyline fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg></div>
                                <div class="step-text"><span>Доставка</span></div>
                            </div>
                            <div class="line done"></div>
                            <div class="step done">
                                <div class="step-icon"><svg viewBox="0 0 16 16"><polyline fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg></div>
                                <div class="step-text"><span>Оплата</span></div>
                            </div>
                            <div class="line active"></div>
                            <div class="step active">
                                <div class="step-icon">4</div>
                                <div class="step-text"><span>Готово</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>