<?php

/**
 * @var $breadcrumbs array
 * @var $category_group_id integer
 * @var $model \app\modules\shop\models\Product
 * @var $object \app\models\BaseObject
 * @var $selected_category \app\modules\shop\models\Category
 * @var $selected_category_id integer
 * @var $selected_category_ids integer[]
 * @var $this yii\web\View
 * @var $values_by_property_id integer
 * @var $default_wish_list Wishlist|null
 */

use app\modules\image\models\Image;
use app\modules\shop\models\Product;
use app\modules\image\widgets\ObjectImageWidget;
use app\modules\shop\models\Wishlist;
use app\widgets\city_text\TextByCity;
use kartik\helpers\Html;
use yii\helpers\Url;
use app\modules\shop\widgets\AddToWishlistWidget;
use yii\widgets\Breadcrumbs;
use app\widgets\SeoCityText\SeoCityText;

$this->title = $this->blocks['title'] . TextByCity::widget(['text' => ' купить в городе {city_name}', 'cityAttribute' => 'parental_case',]);
$this->params['breadcrumbs'] = $breadcrumbs;
$listView = isset($_COOKIE['listViewType']) && $_COOKIE['listViewType'] == 'listView';

$propertiesShowedInAnnounce = false;

if(is_null($default_wish_list ?? null)) {
    $default_wish_list = Wishlist::getDefaultWishlist();
}

//echo TextByCity::widget([
//    'text' => $model->name . ' купить в городе {city_name}',
//    'cityAttribute' => 'parental_case',
//]);
?>
<div class="container product-content__wrapper m-0">
    <div class="row">
        <div class="col-12">
            <div class="product-content__title d-lg-block d-sm-none d-none fade">
                <h1>
                    <?=
                    Html::encode($model->name) .
                    TextByCity::widget(['text' => ' купить в городе {city_name}', 'cityAttribute' => 'parental_case',])
                    ?>
                </h1>
            </div>
        </div>
    </div>
    <div class="row product-content__inner-wrapper fade">
        <div class="col-lg-6">
            <div class="product-content__product-images">
                <div class="owl-carousel owl-theme product-slider" data-slider-id="1">
                    <?= ObjectImageWidget::widget(
                        [
                            'model' => $model,
                            'viewFile' => 'detail_product_imgs',
                        ]
                    ) ?>
                </div>
                <?php if($model->sale): ?>
                    <div class="badges-wrapper">
                        <img src="/theme/dist/img/icons/sale.svg" width="40" height="40">
                    </div>
                <?php endif; ?>
            </div>
            <div class="product-content__title-mobile d-lg-none d-sm-block d-block fade"><?= Html::encode($model->name) ?></div>
            <div class="container p-0" data-incrementally-box>
                <div class="product-content__count d-lg-none flex-sm-column d-flex flex-column align-items-center justify-content-center">
                    <span>Количество:</span>
                    <div class="qty-input">
                        <i class="less">-</i>
                        <input type="number" value="1" min="1" max="999"/>
                        <i class="more">+</i>
                    </div>
                </div>
                <div class="product-content__buttons justify-content-center">
                    <div
                        class="add-to-fav-button
                        <?= (Yii::$app->user->isGuest === true ? '' : 'js__product-content__add-to-fav') ?>
                        <?= $model->inDefaultWishlist() ? 'active' : '' ?>"
                        <?= (Yii::$app->user->isGuest === true ? 'data-fancybox="" data-src="#login-favorite" ' : '') ?>
                        data-list-id="<?= $default_wish_list->id ?>"
                        data-product-id="<?= $model->id ?>"
                    ><i class="fas fa-heart"></i><span> В избранное</span></div>
                    <div class="compare-button d-lg-flex d-sm-none d-none" data-product-id="<?= $model->id ?>"><i class="fas fa-star" ></i><span> Сравнить</span></div>
                    <div class="add-to-cart-button d-lg-none d-sm-flex d-flex" data-incrementally data-product-id="<?= $model->id ?>"><i class="fas fa-shopping-cart"></i><span>Купить</span></div>
                </div>

            </div>
        </div>
        <div class="col-lg-6">
            <div class="product-content__item-price-wrapper mt-xl-0 mt-sm-3 mt-3">
                <?php if ($model->price < $model->old_price): ?>
                    <div class="product-content__item-old-price text-lg-right text-md-center text-center">
                        <span><?= $model->nativeCurrencyPrice(true, false) ?></span>
                    </div>
                <?php endif; ?>
                <meta itemtype="http://schema.org/Offer" itemprop="offers" itemscope="">
                <meta itemprop="priceCurrency" content="RUB">
                <meta itemprop="price" content="">
                <div class="product-content__item-price text-lg-right text-md-center text-center">
                    <span><?= $model->nativeCurrencyPrice(false, true) ?></span>
                </div>
                <div class="d-lg-flex d-none align-items-center justify-content-between my-3" data-incrementally-box>
                    <div class="product-content__count d-lg-flex align-items-center d-sm-none d-none mb-0">
                        <span class="mb-0">Количество:</span>
                        <div class="qty-input qty-input-desktop">
                            <i class="less">-</i>
                            <input type="number" value="1" min="1" max="999"/>
                            <i class="more">+</i>
                        </div>
                    </div>
                    <div class="product-content__buttons">
                        <div class="add-to-cart-button add-to-cart-button-lg d-lg-flex d-sm-none d-none m-0" data-incrementally data-product-id="<?= $model->id ?>">
                            <i class="fas fa-shopping-cart"></i><span> Купить</span>
                        </div>
                    </div>
                </div>
                <div class="product-tabs">
                    <ul class="tabs-nav">
                        <li class="item-tab active-tab"><span>Описание</span></li>
                        <li class="item-tab"><span>Свойства</span></li>

                    </ul>
                    <div class="tabs-content">
                        <div data-simplebar class="tab-content" style="display: block;">
                            <?= $this->blocks['content'] ?>
                        </div>

                        <div data-simplebar class="tab-content" style="display: none;">
                            <meta itemprop="propertiesList" itemscope itemtype="http://schema.org/ItemList">
                            <?= \app\properties\PropertiesWidget::widget(
                                [
                                    'model' => $model,
                                    'viewFile' => 'show-properties-widget',
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="category__list-options d-lg-flex d-sm-none d-none fade">
        <?= SeoCityText::widget([
            'productId' => $model->id,
            'isCategory' => false,
        ]); ?>
    </div>
    
    <style>
        body .logo-wrapper {
            display: none;
        }
    </style>
    <!-- раздел с рекомендациями
    <div class="row">
        <div class="col-12">
            <div class="category__wrapper">
                <div class="category__title-hot text-xl-left text-sm-center text-center"><h2><i class="fas fa-tags"></i> Выгодные предложения </h2></div>
                <div class="category__body" style="box-shadow: none!important;">
                    <div class="owl-carousel owl-carousel-one owl-theme container p-0">

                        <div class="item">
                            <a href="product.html">
                                <div class="slider-item category__item">
                                    <figure style="background-image: url('assets/img/asus.jpg');"></figure>
                                    <div class="fav-button"><i class="fas fa-heart"></i><div class="fav-button-text">Добавить в избранное</div></div>
                                    <div class="category__item-info">
                                        <div class="category__item-title">ASUS X555LD
                                        </div>
                                        <div class="category__item-old-price"><span>50 217р.</span></div>
                                        <div class="category__item-price">40 340р.</div>
                                        <p class="category__item-description">экран: 14"; разрешение экрана: 1920×1080; процессор: Intel Core i7 10510U; частота: 1.8 ГГц (4.9 ГГц, в режиме Turbo); память: 16384 Мб, LPDDR3; SSD: 512 Гб; NVIDIA GeForce MX350 — 2048 Мб; WiFi; Bluetooth; HDMI; WEB-камера; Windows 10 Professional</p>
                                        <div class="category__item-buttons">
                                            <div class="add-to-cart-button"><i class="fas fa-shopping-cart"></i><span> В корзину</span></div>
                                            <div class="compare-button"><i class="fas fa-star" ></i><span> Сравнить</span></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="item">
                            <a href="product.html">
                                <div class="slider-item category__item">
                                    <figure style="background-image: url('assets/img/hp.jpg');"></figure>
                                    <div class="fav-button"><i class="fas fa-heart"></i><div class="fav-button-text">Добавить в избранное</div></div>
                                    <div class="category__item-info">
                                        <div class="category__item-title">HP ProBook 450 G7</div>
                                        <div class="category__item-old-price"><span>72 350р.</span></div>
                                        <div class="category__item-price">50 650р.</div>
                                        <p class="category__item-description">экран: 14"; разрешение экрана: 1920×1080; процессор: Intel Core i7 10510U; частота: 1.8 ГГц (4.9 ГГц, в режиме Turbo); память: 16384 Мб, LPDDR3; SSD: 512 Гб; NVIDIA GeForce MX350 — 2048 Мб; WiFi; Bluetooth; HDMI; WEB-камера; Windows 10 Professional</p>
                                        <div class="category__item-buttons">
                                            <div class="add-to-cart-button"><i class="fas fa-shopping-cart"></i><span> В корзину</span></div>
                                            <div class="compare-button"><i class="fas fa-star" ></i><span> Сравнить</span></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="item">
                            <a href="product.html">
                                <div class="slider-item category__item">
                                    <figure style="background-image: url('assets/img/lenovo.jpg');"></figure>
                                    <div class="fav-button"><i class="fas fa-heart"></i><div class="fav-button-text">Добавить в избранное</div></div>
                                    <div class="category__item-info">
                                        <div class="category__item-title">Lenovo G70-70
                                        </div>
                                        <div class="category__item-old-price"><span>80 600р</span></div>
                                        <div class="category__item-price">68 600р.</div>
                                        <p class="category__item-description">экран: 14"; разрешение экрана: 1920×1080; процессор: Intel Core i7 10510U; частота: 1.8 ГГц (4.9 ГГц, в режиме Turbo); память: 16384 Мб, LPDDR3; SSD: 512 Гб; NVIDIA GeForce MX350 — 2048 Мб; WiFi; Bluetooth; HDMI; WEB-камера; Windows 10 Professional</p>
                                        <div class="category__item-buttons">
                                            <div class="add-to-cart-button"><i class="fas fa-shopping-cart"></i><span> В корзину</span></div>
                                            <div class="compare-button"><i class="fas fa-star" ></i><span> Сравнить</span></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="item">
                            <a href="product.html">
                                <div class="slider-item category__item">
                                    <figure style="background-image: url('assets/img/hp.jpg');"></figure>
                                    <div class="fav-button"><i class="fas fa-heart"></i><div class="fav-button-text">Добавить в избранное</div></div>
                                    <div class="category__item-info">
                                        <div class="category__item-title">HP ProBook 450 G7</div>
                                        <div class="category__item-old-price"><span>72 350р.</span></div>
                                        <div class="category__item-price">50 650р.</div>
                                        <p class="category__item-description">экран: 14"; разрешение экрана: 1920×1080; процессор: Intel Core i7 10510U; частота: 1.8 ГГц (4.9 ГГц, в режиме Turbo); память: 16384 Мб, LPDDR3; SSD: 512 Гб; NVIDIA GeForce MX350 — 2048 Мб; WiFi; Bluetooth; HDMI; WEB-камера; Windows 10 Professional</p>
                                        <div class="category__item-buttons">
                                            <div class="add-to-cart-button"><i class="fas fa-shopping-cart"></i><span> В корзину</span></div>
                                            <div class="compare-button"><i class="fas fa-star" ></i><span> Сравнить</span></div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->
</div>
