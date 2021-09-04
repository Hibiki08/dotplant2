<?php

use app\modules\image\models\Image;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \app\modules\shop\models\Order[] $orders
 * @var string $currentOrder
 * @var \yii\data\ArrayDataProvider $dataProvider
 */
$this->title = Yii::t('app', 'Orders list');
$this->params['breadcrumbs'] = [
    [
        'label' => Yii::t('app', 'Personal cabinet'),
        'url' => '/shop/cabinet'
    ],
    $this->title,
];
?>

<div class="page__title text-xl-left text-sm-center text-center fade"><i class="far fas fa-file-alt"></i>
    <h2 class="d-inline-block"><?= Yii::t('app', 'Заказы') // todo вернуть перевод 'Orders list') ?></h2></div>
<?php if ($currentOrder): ?>
    <div class="current-order">
        <?= Yii::t('app', 'Current order:') ?>
        <?= Html::a($currentOrder, ['/shop/cart']) ?>
    </div>
<?php endif; ?>

<?php if ($dataProvider !== null): ?>
    <div class="container p-0 fade">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="user__orders-wrapper">
                    <?php /** @var app\modules\shop\models\Order $order */ ?>
                    <?php foreach ($dataProvider->models as $order) { ?>
                        <div class="users__orders-single">
                            <div class="user__orders-info">
                                <div class="user__orders-info_block">
                                    <div class="user__orders-data">
                                        <div class="user__orders-date"><?= Yii::$app->formatter->asDate($order->start_date, 'php:d.m.Y') ?></div>
                                        <div class="user__orders-separator">-</div>
                                        <div class="user__orders-ammount"><?= \app\modules\shop\models\Currency::getMainCurrency()->format($order->fullPrice); ?></div>
                                    </div>
                                    <div class="user__orders-number">Номер заказа <?= $order->id ?></div>
                                    <?php 
                                    $trStatuses = [];
                                    foreach($order->transactions as $transaction) {
                                        $trStatuses[] = 
                                        Html::a($transaction->getTransactionStatus(true), \yii\helpers\Url::toRoute(
                                            ['/shop/payment/transaction', 'id' => $transaction->id, 'othash' => $transaction->generateHash()]
                                            ),
                                            ['class' => 'print-without-link']
                                        );
                                    } 
                                    $trStatusTxt = implode(', ', $trStatuses);
                                    ?>
                                    <div class="user__orders-status">
                                        <?= $order->stage->name_frontend ?><?= (!empty($trStatusTxt) ? ": $trStatusTxt"  :'') ?>
                                    </div>
                                </div>
                                <a href="<?= \yii\helpers\Url::to(['/shop/orders/show', 'hash' => $order->hash]) ?>">
                                    <div class="user__orders-view_details">Посмотреть детали</div>
                                </a>
                            </div>
                            <div class="user__orders-items">
                                <div class="owl-carousel order-items owl-theme container p-0 mb-2">
                                    <?php foreach ($order->items as $item) { ?>
                                        <?php if ($product = $item->product) :
                                            /** @var Image $productImage */
                                            $productImage = $item->product->getImages()->one();
                                            if ($productImage) {
                                                $productImageSrc = $productImage->file;
                                            } else {
                                                $productImageSrc = '/theme/images/no-image.png';
                                            }
                                        ?>
                                        <div class="item">
                                            <?= Html::a(
                                                Html::img($productImageSrc),
                                                \yii\helpers\Url::to([
                                                    '/shop/product/show',
                                                    'model' => $item->product,
                                                    'category_group_id' => $item->product->category->category_group_id,
                                                ])
                                            ); ?>
                                        </div>
                                        <?php endif; ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <nav>
                        <div class="pagination w-100 text-center">
                            <?= \justinvoelker\separatedpager\LinkPager::widget([
                                'pagination' => $dataProvider->getPagination(),
                                'maxButtonCount'=> 7,
                            ]) ?>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?= Yii::t('app', 'You have no complete orders') ?>
<?php endif; ?>
