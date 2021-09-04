<?php

/**
 * @var $content string
 * @var $this \app\components\WebView
 */

//use app\extensions\DefaultTheme\assets\DefaultThemeAsset;
use app\extensions\DefaultTheme\models\ThemeParts;
use app\web\theme\module\assets\ThemeAsset;
use app\modules\seo\helpers\HtmlTagHelper;
use yii\helpers\Html;
use app\widgets\Alert;
use yii\widgets\Breadcrumbs;
use app\web\theme\widgets\MenuTree;

//DefaultThemeAsset::register($this);
ThemeAsset::register($this);
HtmlTagHelper::addTagOptions('html', 'lang', Yii::$app->language);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html <?= HtmlTagHelper::registerTagOptions('html')?>>
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--base href="http://<?= Yii::$app->getModule('core')->getBaseUrl() ?>"-->
	<title><?= Html::encode($this->title) ?></title>
	<?= Html::csrfMetaTags() ?>
    <?php $this->head(); ?>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
</head>
<body itemscope itemtype="http://schema.org/WebPage">
<?php $this->beginBody(); ?>

<?= ThemeParts::renderPart('pre-header') ?>
<?= ThemeParts::renderPart('header') ?>
<?= ThemeParts::renderPart('post-header') ?>

<main>
	<div class="container">
		<div class="row">
            <div class="col-lg-3 col-12">
                <?php /* Task 288: Убрать лишние хлебные крошки и поправить заголовки
                <div class="container mt-3 d-lg-none d-sm-block d-block fade">
					<?= Breadcrumbs::widget([
							'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
							'options' => [
								'itemprop' => "breadcrumb",
								'class' => 'breadcrumb',
							]
						])?>
                    <div class="category__title text-xl-left text-sm-center text-center fade">
						<i class="fab fa-gratipay"></i>
						<h1><?= $this->title ?></h1>
					</div>
                </div>
                */ ?>
                
                <?= MenuTree::widget([
                    'start' => 1,
                    'closer' => 0,
                    'table' => 'category',
                    'order' => '`sort_order` ASC',
                    'title_field' => 'h1',
                    'link' => 'slug']
                )
                ?>

                <div class="menu-aside__wrapper fade">
                    <div class="menu-aside__header"><h2><a href="/shop/cabinet">Личный кабинет</a></h2></div>
                    <ul class="menu-aside__items">
                        <li class="menu-aside__item"><a href="/user/user/profile">Контактные данные</a></li>
                        <li class="menu-aside__item"><a href="/shop/address/list">Адреса</a></li>
                    </ul>
                    <div class="menu-aside__header mb-3"><h2><a href="/shop/orders/list">Заказы</a></h2></div>

                    <?php /* 
                    <ul class="menu-aside__items">
                        <li class="menu-aside__item"><a href="/shop/orders/list">Список заказов</a></li>
                    </ul>
                    */ ?>

                    <div class="menu-aside__header"><h2><a href="/shop/wishlist">Избранное</a></h2></div>
                    <div class="menu-aside__header d-lg-none d-sm-block d-block "><h2><a href="/logout">Выйти</a></h2></div>
                </div>
            </div>

            <div class="col-lg-9 col-12">
                <div class="container">
                    <div class="page__wrapper fade">
                        <?php /* Task 288: Убрать лишние хлебные крошки и поправить заголовки
                        <?= Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                'options' => [
                                    'itemprop' => "breadcrumb",
                                    'class' => 'breadcrumb',
                                ]
                            ]) ?>
                        */ ?>
                        <?= Alert::widget() ?>
                        <!-- content -->
                        <?= $content ?>
                        <!-- content end-->
                    </div> <!-- content-part end 1 -->
                </div>
            </div>
			<?php

			if (!empty($rightSidebar)) {
				echo '<div class="right-sidebar col-md-'.$rightSidebarLength.' col-xs-12">' . $rightSidebar . '</div>';
			}
			?>
		</div> <!-- /row -->
	</div> <!-- /container -->
</main>



<?= ThemeParts::renderPart('pre-footer') ?>
<?= ThemeParts::renderPart('footer') ?>
<?= ThemeParts::renderPart('post-footer') ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage();?>
