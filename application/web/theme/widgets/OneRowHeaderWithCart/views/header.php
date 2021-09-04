<?php

use app\widgets\contacts\CityContacts;
use app\widgets\subdomain\SubdomainSelect;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
use app\modules\shop\models\Wishlist;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use app\web\theme\widgets\MenuTree;

/** @var yii\web\View $this */
/**
 * @var \app\modules\shop\models\Order $order
 */
/** @var bool $collapseOnSmallScreen */
/** @var bool $useFontAwesome */
/** @var \app\extensions\DefaultTheme\Module $theme */

$mainCurrency = \app\modules\shop\models\Currency::getMainCurrency();
if (is_null($order)) {
    $itemsCount = 0;
} else {
    $itemsCount = $order->items_count;
}
$wishlistCount = (int)Wishlist::countItems((!Yii::$app->user->isGuest ? Yii::$app->user->id : 0), Yii::$app->session->get('wishlists', []));
$compareProductsCount = count(Yii::$app->session->get('comparisonProductList', []));
$navStyles = '';

$uri = explode("/", Yii::$app->request->url);
$dnone = ($uri[1] == 'catalog')?'d-sm-none d-none':'';
?>
<div class="content">
<header class="page-header">
    <div class="container-fluid d-lg-block d-none top-bar-wrapper">
        <div class="row">
            <div class="container d-flex justify-content-between align-items-center top-bar">
                <span>
                    <?= SubdomainSelect::widget([
                        'subdomainSetUrl' => Url::to(['/default/change-subdomain']),
                        'subdomainSearchUrl' => Url::to(['/default/subdomains']),
                    ]) ?>
                </span>
                <span><?= CityContacts::widget() ?></span>
            </div>
        </div>
    </div>
        <!--a href="/" class="pull-left logo">
            <img src="<?= Html::encode($theme->logotypePath) ?>" alt="<?= Html::encode($theme->siteName) ?>"/>
        </a-->
        <?php /*if ($collapseOnSmallScreen === true): ?>
            <a href="#" rel="nofollow" class="collapsed nav-sm-open" data-toggle="collapse" data-target="#header-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <?php if ($useFontAwesome):?>
                    <i class="fa fa-bars"></i>
                <?php else: ?>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <?php endif; ?>
            </a>
        <?php endif; */?>

        <nav class="navbar">
            <div class="container p-0 d-flex flex-lg-row flex-column align-items-center justify-content-between">
                        <div class="logo-wrapper d-lg-flex <?= $dnone ?>">
                            <a href="<?= Yii::$app->homeUrl ?>"><img src="/theme/images/logo.svg" width="200" alt="SexToys365"></a>
                        </div>

                        <?= MenuTree::widget([
                            'start' => 1,
                            'inHeader' => true,
                            'table' => 'category',
                            'order' => '`sort_order` ASC',
                            'title_field' => 'h1',
                            'link' => 'slug'
                            ])
                        ?>

                        <?= \app\extensions\DefaultTheme\widgets\OneRowHeaderWithCart\ExpandableSearchField::widget([
                            'useFontAwesome' => false, //$useFontAwesome,
                            'autocomplete' => false,
                            'inputClass' => 'search-box d-lg-block d-sm-none d-none',
                        ]) ?>



                        <div class="d-lg-flex d-sm-none d-none align-items-center justify-content-lg-end justify-content-sm-center justify-content-center flex-row p-lg-0 p-1 personal-area">
                            <div class="personal-area__catalog d-lg-none d-sm-flex d-flex">
                                <a href="#"><i class="fas fa-th-large"></i><span>Каталог</span></a>
                            </div>
                            <?php if (!Yii::$app->user->isGuest): ?>
                            <div class="personal-area__fav<?= $wishlistCount > 0 ? ' active' : ''?>">
                                <a href="<?=Url::to(['/shop/wishlist'])?>">
                                    <i class="fas fa-heart">
                                        <div class="fav-items">
                                            <?= $wishlistCount ?>
                                        </div>
                                    </i>
                                    <span>Избранное</span>
                                </a>
                            </div>
                            <?php endif;?>
                            <div class="personal-area__compare<?= $compareProductsCount > 0 ? ' active' : ''?>">
                                <a href="<?=Url::to(['/shop/product-compare/compare'])?>">
                                    <i class="fas fa-star">
                                        <div class="compare-items"><?= $compareProductsCount ?></div>
                                    </i>
                                    <span>Сравнить</span>
                                </a>
                            </div>
                            <div class="personal-area__cart<?= $itemsCount > 0 ? ' active' : ''?>">
                                <a href="<?= Url::toRoute(['/shop/cart']) ?>">
                                    <i class="fas fa-shopping-cart">
                                        <div class="cart-items"><?= $itemsCount ?></div>
                                    </i>
                                    <span>Корзина</span>
                                </a>
                            </div>
                            <?php if (Yii::$app->user->isGuest == true): ?>
                                <div class="personal-area__register">
                                    <a data-fancybox="" data-src="#register-modal" href="#">
                                    <i class="fas fa-user"></i>
                                    <span>Регистрация</span></a>
                                </div>
                                <div class="personal-area__login">
                                    <a data-fancybox="" data-src="#login-modal" href="#">
                                        <div class="d-md-flex d-xs-none d-none login-button"><span>Войти </span><i class="fas fa-sign-in-alt"></i></div>
                                        <div class="d-md-none d-sm-block d-block"><i class="fas fa-sign-in-alt"></i><span> Войти</span></div>
                                    </a>
                                </div>

                                <div id="register-modal" style="display: none;">
                                    <?= $this->render('@app/modules/user/views/user/signup', [
                                        'model' => new \app\modules\user\models\RegistrationForm(),
                                    ])?>
                                </div>

                                <div id="login-modal" style="display: none;">
                                    <?= $this->render('@app/modules/user/views/user/login', [
                                        'model' => new \app\modules\user\models\LoginForm(),
                                    ])?>
                                </div>
                                
                                <div id="login-favorite" style="display: none;">
                                    <?= $this->render('@app/modules/user/views/user/login', [
                                        'model' => new \app\modules\user\models\LoginForm(),
                                        'isFavorite' => true,
                                    ])?>
                                </div>
                                
                                <div id="reset-password-modal" style="display: none;">
                                    <?= $this->render('@app/modules/user/views/user/requestPasswordResetToken', [
                                        'model' => new \app\modules\user\models\PasswordResetRequestForm(),
                                    ])?>
                                </div>
                            <?php else: ?>
                                <div class="personal-area__login active">
                                <a href="/shop/cabinet"><div class="login-button"><i class="fas fa-user"></i><span>Личный кабинет</span></div></a>
                                <ul>
                                    <li><a href="/shop/cabinet">Личный кабинет</a></li>
                                    <li><a href="/user/user/profile">Профиль</a></li>
                                    <li><a href="/shop/orders/list">Заказы</a></li>
                                    <li><a href="/logout">Выйти</a></li>
                                </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- mobile nav -->
                        <div class="d-lg-none d-sm-flex d-flex align-items-center justify-content-around flex-row p-lg-0 p-1 personal-area">
                            <div class="personal-area__home d-lg-none d-sm-flex d-flex">
                                <a href="<?=Url::to(['/'])?>">
                                    <img src="/theme/dist/img/icons/menu-icons/home.svg" width="30" height="30" alt="Главная">
                                </a>
                            </div>
                            <div class="personal-area__catalog d-lg-none d-sm-flex d-flex">
                                <a href="javascript:;">
                                    <img src="/theme/dist/img/icons/menu-icons/catalog.svg" width="30" height="30" alt="Каталог">
                                </a>
                            </div>
                            <?php if (!Yii::$app->user->isGuest): ?>
                            <div class="personal-area__fav <?= $wishlistCount > 0 ? ' active' : ''?>">
                                <a href="<?=Url::to(['/shop/wishlist'])?>">
                                    <img src="/theme/dist/img/icons/menu-icons/fav.svg" width="30" height="30" alt="Избранное">
                                    <span class="fav-items-mobile"><?= $wishlistCount ?></span>
                                </a>
                            </div>
                            <?php endif; ?>
                            <div class="personal-area__cart <?= $itemsCount > 0 ? ' active' : ''?>">
                                <a href="<?= Url::toRoute(['/shop/cart']) ?>">
                                    <img src="/theme/dist/img/icons/menu-icons/cart.svg" width="30" height="30" alt="Корзина">
                                    <span class="cart-items-mobile"><?= $itemsCount ?></span>
                                </a>
                            </div>
                            <div class="personal-area__login">
                                <?php if (Yii::$app->user->isGuest) { ?>
                                    <a data-fancybox data-src="#login-modal" href="javascript:;">
                                        <img src="/theme/dist/img/icons/menu-icons/user.svg" width="30" height="30" alt="Войти">
                                    </a>
                                <?php } else { ?>
                                    <a href="<?= Url::toRoute(['/shop/cabinet']) ?>">
                                        <img src="/theme/dist/img/icons/menu-icons/user.svg" width="30" height="30" alt="Пользователь">
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
            </div>
        </nav>
        <?php /*
        <div class="pull-right personal-area">
            <?php  if (Yii::$app->user->isGuest === true): ?>
                <a href="<?= \yii\helpers\Url::toRoute(['/user/user/signup']) ?>" class="btn btn-signup hidden-xs">
                    <?= Yii::t('app', 'Sign up') ?>
                </a>
                <a href="<?= \yii\helpers\Url::toRoute(['/user/user/login']) ?>" class="btn btn-login">
                    <?= Yii::t('app', 'Login') ?>
                </a>
            <?php else: ?>
                <?= Yii::t('app', 'Hi') ?>,
                <span class="dropdown">
                    <a href="<?= \yii\helpers\Url::toRoute(['/shop/cabinet']) ?>" class="link-cabinet" data-toggle="dropdown" data-hover="dropdown"><?= Html::encode(Yii::$app->user->identity->username) ?></a>!
                    <?= \yii\widgets\Menu::widget([
                        'items' => [
                            [
                                'label' => Yii::t('app', 'User profile'),
                                'url' => ['/user/user/profile'],
                                [
                                    'class' => 'user-profile-link',
                                ]
                            ],
                            [
                                'label' => Yii::t('app', 'Personal cabinet'),
                                'url' => ['/shop/cabinet'],
                                [
                                    'class' => 'shop-cabinet-link',
                                ]
                            ],
                            [
                                'label' => Yii::t('app', 'Orders list'),
                                'url' => ['/shop/orders/list'],
                                [
                                    'class' => 'shop-orders-list',
                                ]
                            ],
                            [
                                'label' => Yii::t('app', 'Logout'),
                                'url' => ['/user/user/logout'],
                                [
                                    'data-action' => 'post',
                                    'class' => 'logout-link',
                                ],
                            ]
                        ],
                        'options' => [
                            'class' => 'dropdown-menu personal-menu',
                        ],
                    ]) ?>
                </span>
            <?php endif;  ?>
            
            
            <a href="<?= \yii\helpers\Url::toRoute(['/shop/cart']) ?>" class="btn btn-show-cart">
                <i class="fa fa-shopping-cart cart-icon"></i>
                <span class="badge items-count">
                    <?= $itemsCount ?>
                </span>
            </a>
            
            <a href="<?=Url::to(['/shop/product-compare/compare'])?>" class="btn btn-compare" title="<?=Yii::t('app', 'Compare products')?>">
                <i class="fa fa-tags"></i>
                <span class="badge items-count">
                    <?=count(Yii::$app->session->get('comparisonProductList', [])) ?>
                </span>
            </a>
            
            
            <a href="<?=Url::to(['/shop/wishlist'])?>" class="btn btn-wishlist">
                <i class="fa fa-heart"></i>
                <span class="badge items-count">
                    <?= Wishlist::countItems((!Yii::$app->user->isGuest ? Yii::$app->user->id : 0), Yii::$app->session->get('wishlists', [])) ?>
                </span>
            </a>
        
        </div>
        <div class="pull-right search-area">

        <?= \app\extensions\DefaultTheme\widgets\OneRowHeaderWithCart\ExpandableSearchField::widget([
            'useFontAwesome' => $useFontAwesome,
        ]) ?>


        </div>
        */ ?>

    
</header>

<?php

if (Yii::$app->user->isGuest === false) {
    $js = <<<JS
$('.link-cabinet').dropdownHover();
JS;
    $this->registerJs($js);

}
