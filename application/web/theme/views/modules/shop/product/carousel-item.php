<?php

/**
 * @var $product \app\modules\shop\models\Product
 * @var $this \app\components\WebView
 * @var $url string
 * @var $default_wish_list Wishlist|null
 */

use app\modules\image\widgets\ObjectImageWidget;
use app\modules\shop\models\Wishlist;
use kartik\helpers\Html;

if(is_null($default_wish_list ?? null)) {
    $default_wish_list = Wishlist::getDefaultWishlist();
}
?>

<div class="item">
    <a href="<?= $url ?>">
        <div class="slider-item category__item">
            <?= ObjectImageWidget::widget(
                [
                    'limit' => 1,
                    'model' => $product,
                    'viewFile' => 'product_img',
                ]
            ) ?>
            <?php if($product->sale): ?>
                <div class="badges-wrapper">
                    <img src="/theme/dist/img/icons/sale.svg" width="40" height="40">
                </div>
            <?php endif; ?>
            <div class="fav-button js__fav-button d-lg-block d-sm-none d-none <?= (Yii::$app->user->isGuest === true ? '' : 'js__fav-button') ?>
                    <?= $product->inDefaultWishlist() ? 'active' : '' ?>"
                    <?= (Yii::$app->user->isGuest === true ? 'data-fancybox="" data-src="#login-favorite" ' : '') ?>
                    data-list-id="<?= $default_wish_list->id ?>"
                    data-product-id="<?= $product->id ?>">
                <i class="fas fa-heart"></i>
                <div class="fav-button-text"><?= $product->inDefaultWishlist() ? 'Убрать из избранного' : 'Добавить в избранное' ?></div>
            </div>
            <div class="category__item-info">
                <div class="category__item-title">
                    <?= Html::encode($product->name) ?>
                </div>

                <?php if($product->old_price): ?>
                    <div class="category__item-old-price">
                        <span><?= $product->formattedPrice(null, true, false) ?></span>
                    </div>
                <?php endif; ?>
                
                <div class="category__item-price">
                    <?= $product->formattedPrice(null, false, false) ?>
                </div>

                <p class="category__item-description"><?= $product->announce ?></p>
                <div class="category__item-buttons">
                    <div class="add-to-cart-button" data-product-id="<?= $product->id ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span> <?= Yii::t('app', 'Купить') ?></span>
                    </div>
                    <div
                            class="compare-button d-lg-flex d-sm-none d-none"
                            data-list-id="<?= $default_wish_list->id ?>"
                            data-product-id="<?= $product->id ?>"
                    >
                        <i class="fas fa-star"></i>
                        <span> <?= Yii::t('app', 'Сравнить') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

