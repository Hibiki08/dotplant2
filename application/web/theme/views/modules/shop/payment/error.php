<?php
/**
 * @var \yii\web\View $this
 * @var \app\modules\shop\models\OrderTransaction $transaction
 */
    $this->title = Yii::t('app', 'Payment error');
?>
<div class="container p-0">
    <div class="page__wrapper fade" style="opacity: 1;">
        <div class="page__title text-xl-left text-sm-center text-center fade" style="opacity: 1;"><i class="fas fa-file-alt"></i><h1><?= Yii::t('app', 'Payment error') ?></h1></div>
        <div class="container p-0 fade" style="opacity: 1;">
            <div class="shop_cart__payment-success container p-3 text-center ь">
                <h2 class="mb-3">К сожалению, что-то пошло не так и оплата товара не прошла</h2>
                <p class="pt-3">
                    <?= Yii::t('app', 'Вы можете повторить оплату') ?>
                    <span class="colored dotted">
                        <?= \yii\helpers\Html::a(
                            Yii::t('app', 'here'),
                            ['/shop/payment/transaction', 'id' => $transaction->id, 'othash' => $transaction->generateHash()],
                            ['class' => 'btn btn-info'])
                        ?>
                    </span>
                </p>
                <p>
                    <?= Yii::t('app', 'Вы можете увидеть статус Вашего заказа') ?>
                    <span class="colored dotted">
                        <?= \yii\helpers\Html::a(
                            Yii::t('app', 'here'),
                            [
                                '/shop/orders/show',
                                'hash' => $transaction->order->hash
                            ],
                            ['class' => 'btn btn-info'])
                        ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
