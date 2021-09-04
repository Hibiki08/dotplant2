<?php

use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $wishlist app\modules\shop\models\Wishlist
 */
$isEmptyList = !$wishlist || count($wishlist->items) === 0;
$this->title = Yii::t('app', 'Избранное');

?>
<div class="page__wrapper fade">
    <div class="container">
        <div class="page__title text-xl-left text-sm-center text-center fade">
            <i class="fas fa-heart"></i>
            <h1><?= Yii::t('app', 'Избранное') ?></h1>
        </div>
        <?php
        if (!isset($wishlist->items)) {
            ?>
            <div class="wishlists-are-empty" <?= $isEmptyList ? '' : 'style="display:none"' ?>>
                <h3 class="wishlists-are-empty-title">
                    <?= Yii::t('app', 'У вас нету списка избранных товаров') ?>
                </h3>
            </div>
            <?php
        } else {
            ?>
            <div class="container p-0 fade">
                <div class="row">
                    <?php foreach ($wishlist->items as $item) { ?>
                        <?php
                        $url = Url::to([
                            '@product',
                            'model' => $item->product,
                            'category_group_id' => $item->product->category->category_group_id,
                        ]);

                        echo $this->render('item',
                            [
                                'product' => $item->product,
                                'url' => $url,
                                'wishlist' => $wishlist,
                                'item' => $item,
                            ]
                        ) ?>
                    <?php } ?>
                </div>
                <div class="container p-0 fav-mass-buttons" <?= $isEmptyList ? 'style="display:none"' : '' ?>>
                    <div class="d-flex flex-sm-row flex-xs-column flex-column justify-content-sm-between justify-content-xs-center justify-content-center align-items-center">
                        <div class="fav-page__form-button fav-mass-button-del"><?= Yii::t('app', 'Удалить выбранное') ?></div>
                        <div class="fav-page__form-button mass-add-to-cart">
                            <i class="fa fa-shopping-cart"></i><?= Yii::t('app', 'Добавить в корзину') ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
