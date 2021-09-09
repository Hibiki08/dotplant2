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
use yii\helpers\Url;

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
    <?php $subdomain = Yii::$app->subdomainService->getSubdomain(); ?>
    <?php $contact = $subdomain ? array_shift($subdomain->contacts) : null; ?>
    <script type="application/ld+json">
        [
            {
                "@type": "EducationalOrganization",
                "telephone": "<?php echo $contact ? $contact->phone_number : ''; ?>",
                "email": "mailto:<?php echo $contact ? $contact->email : ''; ?>",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "<?php echo $subdomain ? $subdomain->title : ''; ?>, Россия"
                }
            },
            {
                "@type": "Organization",
                "@id": "<?php echo Yii::$app->request->getHostInfo() . Url::to('/about'); ?>",
                "name": "SexToys36",
                "description": "<?php echo Yii::$app->request->getHostInfo() . Url::to('/about'); ?>",
               "url": "<?php echo Yii::$app->request->getHostInfo(); ?>",
                "logo": "<?php echo Yii::$app->request->getHostInfo() . Url::to('/theme/images/logo.svg'); ?>",
                "telephone": "<?php echo $contact ? $contact->phone_number : ''; ?>",
                "email": "<?php echo $contact ? $contact->email : ''; ?>",
                "foundingDate": "2006",
                "location": {
                    "@type": "Place",
                    "name": "Офис в городе <?php echo $subdomain ? $subdomain->title : ''; ?>",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "<?php echo $subdomain ? $subdomain->title : ''; ?>, Россия",
                        "addressCountry": {
                            "@type": "Country",
                            "name": "Россия"
                        }
                    }
                },
                "contactPoint": {
                    "@type": "ContactPoint",
                    "name": "Офис в городе <?php echo $subdomain ? $subdomain->title : ''; ?>",
                    "telephone": "<?php echo $contact ? $contact->phone_number : ''; ?>",
                    "contactType": "customer service"
                },
                "foundingLocation": {
                    "@type": "Place",
                    "name": "<?php echo $subdomain ? $subdomain->title : ''; ?>"
                }
            },
            {
                "@type": "Product",
                "aggregateRating": {
                    "@type": "AggregateRating",
                    "bestRating": "100",
                    "ratingCount": "24",
                    "ratingValue": "87"
                },
                "name": "<?php echo $this->title; ?>",
                "offers": {
                    "@type": "AggregateOffer",
                    "highPrice": "$1495",
                    "lowPrice": "$1250",
                    "offerCount": "8",
                    "offers": [
                        {
                            "@type": "Offer",
                            "url": "save-a-lot-monitors.com/dell-30.html"
                        },
                        {
                            "@type": "Offer",
                            "url": "jondoe-gadgets.com/dell-30.html"
                        }
                    ]
                }
            }
        ]
    </script>

</head>
<body itemscope itemtype="http://schema.org/WebPage">
<?php $this->beginBody(); ?>

<?= ThemeParts::renderPart('pre-header') ?>
<?= ThemeParts::renderPart('header') ?>
<?= ThemeParts::renderPart('post-header') ?>
<?php

use app\widgets\Alert;
use app\web\theme\widgets\MenuTree;
use yii\widgets\Breadcrumbs;

$uri = explode("/", Yii::$app->request->url);
$dnone = (!isset($uri[4]))?'lg-':'';
?>

<div class="content-block">
	<div class="container">
		<div class="row">
            <div class="col-lg-3 col-12">
                <?php $showProductPage = Yii::$app->controller->action->id == 'show' ?>
                <?php // не хочу ради одной страницы новый layout делать ?>
                <?php if ($showProductPage) { ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <br>
                                <a href="javascript:history.back()"><div class="product-content__arrow-back d-lg-none d-sm-block d-block"><i class="fas fa-chevron-left"></i></div></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="container mt-3 d-<?=$dnone?>none d-sm-block d-block fade">
                    <div class="category__title d-<?=$dnone?>none text-xl-left text-sm-center text-center fade">
                        <i class="fab fa-gratipay"></i>
                        <h1><?= $this->title ?></h1>
                    </div>
                </div>

                <?= MenuTree::widget([
                        'start' => 1,
                        'closer' => 1,
                        'table' => 'category',
                        'order' => '`sort_order` ASC',
                        'title_field' => 'h1',
                        'link' => 'slug']
                )
                ?>

                <?php if(($this->params['hideFilters'] ?? true) != true):?>
                <?= app\extensions\DefaultTheme\widgets\FilterSets\Widget::widget([
                    'themeWidgetModelId' => 5,
                    'viewFile' => 'filter-sets-new',
                    'usePjax' => true,
                    'useNewFilter' => true,
                ]); ?>
                <?php endif; ?>
            </div>

			<div id="js__catalog-top" class="content-part col-lg-9 col-12">
                        <?= Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            'options' => [
                                'itemprop' => "breadcrumb",
                                'class' => 'breadcrumb d-lg-block fade pt-1 pl-2 pb-2 m-0 mt-3' . ($showProductPage ? ' d-sm-none d-none' : ''),
                            ]
                        ])?>
				<?= Alert::widget() ?>
				<!-- content -->
				<?= $content ?>
				<!-- content end-->
			</div> <!-- content-part end 1 -->

			<?php

			if (!empty($rightSidebar)) {
				echo '<div class="right-sidebar col-md-'.$rightSidebarLength.' col-xs-12">' . $rightSidebar . '</div>';
			}
			?>
		</div> <!-- /row -->
	</div> <!-- /container -->
</div>



<?= ThemeParts::renderPart('pre-footer') ?>
<?= ThemeParts::renderPart('footer') ?>
<?= ThemeParts::renderPart('post-footer') ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage();?>
