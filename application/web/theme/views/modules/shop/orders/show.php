<?php
/**
 * @var \app\modules\shop\models\Order $order
 * @var \yii\web\View $this
 */

use app\modules\image\models\Image;
use kartik\helpers\Html;

$this->title = Yii::t('app', 'Order #{order}', ['order' => $order->id]);
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Personal cabinet'),
        'url' => ['/shop/cabinet/']
    ],
    [
        'label' => Yii::t('app', 'Orders list'),
        'url' => ['/shop/orders/list']
    ],
    $this->title,
];

$orderIsImmutable = Yii::$app->user->isGuest
    ? true
    : $order->getImmutability(\app\modules\shop\models\Order::IMMUTABLE_USER);
?>

<div class="page__title text-xl-left text-sm-center text-center fade"><i class="far fas fa-file-alt"></i><h2 class="d-inline-block"><?= Yii::t('app', 'Order information') ?></h2></div>
<div class="container p-0 fade">
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="user__single_order-wrapper">
                <div class="user__single_order-info">
                    <div class="user__single_order-info_block">
                        <div class="user__single_order-data">
                            <div class="user__single_order-date"><?= Yii::$app->formatter->asDate($order->start_date,
                                    'php:d.m.Y') ?></div>
                            <div class="user__single_order-number">Номер заказа <?= $order->id ?></div>
                        </div>
                        <div class="user__single_order-ammount"><?= \app\modules\shop\models\Currency::getMainCurrency()->format($order->fullPrice); ?></div>
                    </div>
                    <?php /* <div class="user__single_order-delivery">Ваш заказ был отправлен 20.08.2020</div> */ ?>
                </div>
                <?php foreach ($order->items as $item) { ?>
                    <?php $product = $item->product ?>
                    <?php $productUrl = \yii\helpers\Url::to([
                        '/shop/product/show',
                        'model' => $item->product,
                        'category_group_id' => $item->product->category->category_group_id,
                    ]) ?>
                    <a href="<?= $productUrl ?>">
                        <div class="user__single_order-item">
                            <div class="row no-gutters">
                                <div class="col">
                                    <div class="user__single_order-item-image">
                                        <?php
                                            $product = $item->product;
                                            /** @var Image $productImage */
                                            $productImage = $item->product->getImages()->one();
                                            if ($productImage) {
                                                $productImageSrc = $productImage->file;
                                            } else {
                                                $productImageSrc = '/theme/images/no-image.png';
                                            }
                                            echo Html::img($productImageSrc);
                                        ?>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="user__single_order-item-data">
                                        <div class="user__single_order-item-title"><?= Html::encode($product->name) ?></div>
                                        <div class="user__single_order-item-description"><?= $product->announce ?></div>
                                        <?php if ($product->old_price): ?>
                                            <div class="user__single_order-item-old-price">
                                                <span><?= $product->formattedPrice(null, true, false) ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="user__single_order-item-price">
                                            <span><?= $product->formattedPrice(null, false, false) ?></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php } ?>

                <?php if (!empty($order->contragent)) { ?>

                    <div class="user__single_order-item-address">
                        <div class="user__single_order-item-address-header">Адрес доставки:</div>
                        <p>
                            <?= $order->contragent->deliveryInformation->zip_code ?><br>
                            <?= $order->contragent->deliveryInformation->country->name ?><br>
                            <?= $order->contragent->deliveryInformation->city->name ?><br>
                            <?= $order->contragent->deliveryInformation->address ?><br>
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
