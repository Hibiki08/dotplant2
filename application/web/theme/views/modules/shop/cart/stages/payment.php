<?php
/**
 * @var \yii\web\View $this
 * @var \yii\bootstrap\ActiveForm $form
 * @var \app\modules\shop\models\PaymentType[] $paymentTypes
 * @var integer $totalPayment
 */

use app\modules\shop\helpers\OrderStageHelper;
use yii\helpers\Html;
use yii\helpers\Url;

    $currency = \app\modules\shop\models\Currency::getMainCurrency();

/*
<div class="col-md-6 col-md-offset-3 tut">
    <div class="row">
        <div>К оплате: <?= $currency->format($totalPayment); ?></div>
        <?= \yii\bootstrap\Html::dropDownList('PaymentType', null, array_reduce($paymentTypes,
            function($result, $item)
            {
                /** @var \app\modules\shop\models\PaymentType $item *//*
                $result[$item->id] = $item->name;
                return $result;
            }, []),
            [
                'class' => 'form-control',
            ]
        ); ?>
    </div>
</div>

*/ ?>
<div class="payment-type">
    <?php foreach ($paymentTypes as $paymentType) { ?>
        <div class='payment-type-select' data-value="<?= $paymentType->id ?>">
            <img src="<?= $paymentType->logo ?>" alt="<?= $paymentType->name ?>">
            <div class="title"><?= $paymentType->name ?></div>
            <div class="subtitle"><?= $paymentType->description ?></div>
        </div>
    <?php }?>
</div>
<input type="hidden" id="payment-type" name="PaymentType" value="0"/>

<div class="payment-button container p-0 mt-3 fade payment-total__wrapper">
    <div class="shop-cart__verify-button d-flex flex-column justify-content-md-arround justify-content-sm-center justify-content-center align-items-center p-3">
        <div class="shop-cart__total-sum p-3"><span class="d-block text-center">Сумма к оплате:</span> <?= $currency->format($totalPayment); ?></div>

        <a href="checkout_success.html">
            <div class="shop-cart__form-button checkout">
                <?=
                    array_reduce(
                        OrderStageHelper::getNextButtons($stage),
                        function ($result, $item) {
                            $result .= Html::submitButton($item['label'] . '<i class="fas fa-check ml-2"></i>', ['data-action' => $item['url'], 'class' => 'shop-cart__form-button checkout']);
                            return $result;
                        },
                        ''
                    );
                    ?>
            </div>
        </a>
    </div>
</div>