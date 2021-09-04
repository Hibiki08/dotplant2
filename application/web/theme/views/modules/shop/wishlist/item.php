<?php

/**
 * @var $product \app\modules\shop\models\Product
 * @var $this \app\components\WebView
 * @var $url string
 * @var $wishlist app\modules\shop\models\Wishlist
 * @var $item app\modules\shop\models\WishlistProduct
 */

use app\modules\image\widgets\ObjectImageWidget;
use kartik\helpers\Html;

?>

<div class="col-xl-4 col-md-6 col-12 fav-page__item-col">
    <a href="<?= $url ?>">
        <div class="slider-item category__item" data-product-id="<?= $product->id ?>">
            <?= ObjectImageWidget::widget(
                [
                    'limit' => 1,
                    'model' => $product,
                    'viewFile' => 'product_img',
                ]
            ) ?>
            <div class="fav-button-select" data-click-state="0">
                <i class="fas fa-check"></i>
                <div class="fav-button-select-text"><?= Yii::t('app', 'Выбрать') ?></div>
            </div>
            <div class="fav-button-del" data-product-id="<?= $product->id ?>" data-list-id="<?= $wishlist->id ?>">
                <i class="fas fa-times"></i>
                <div class="fav-button-del-text"><?= Yii::t('app', 'Удалить из списка') ?></div>
            </div>
            <div class="category__item-info">
                <div class="category__item-title"><?= Html::encode($product->name) ?></div>
                <div class="category__item-price"><?= $product->formattedPrice(null, false, false) ?></div>
                <p class="category__item-description"><?= $product->announce ?></p>
                <div class="category__item-buttons">
                    <div class="add-to-cart-button" data-product-id="<?= $product->id ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span> <?= Yii::t('app', 'Купить') ?></span>
                    </div>
                    <div class="compare-button d-lg-flex d-sm-none d-none" data-product-id="<?= $product->id ?>">
                        <i class="fas fa-star"></i>
                        <span> <?= Yii::t('app', 'Сравнить') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
