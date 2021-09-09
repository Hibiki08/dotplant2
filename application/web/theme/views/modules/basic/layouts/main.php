<?php

/**
 * @var $content string
 * @var $this \app\components\WebView
 */

//use app\extensions\DefaultTheme\assets\DefaultThemeAsset;
use app\components\Helper;
use app\extensions\DefaultTheme\models\ThemeParts;
use app\models\City;
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
                "@context" : "http://schema.org" ,
                "@type": "EducationalOrganization",
                "telephone": "<?php echo $contact ? $contact->phone_number : ''; ?>",
                "email": "mailto:<?php echo $contact ? $contact->email : ''; ?>",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "<?php echo $subdomain ? $subdomain->title : ''; ?>, Россия"
                }
            },
            {
                "@context" : "http://schema.org" ,
                "@type": "Organization",
                "@id": "<?php echo Yii::$app->request->getHostInfo() . Url::to('/about'); ?>",
                "name": "SexToys36",
                "description": "<?php echo Yii::$app->response->meta_description; ?>",
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
                "@context" : "http://schema.org" ,
                "@type": "WebSite",
                "url": "<?php echo Yii::$app->request->getHostInfo(); ?>",
                "description": "<?php echo Yii::$app->response->meta_description; ?>",
                "keywords": "<?php echo $this->title; ?>",
                "logo": "<?php echo Yii::$app->request->getHostInfo() . Url::to('/theme/images/logo.svg'); ?>",
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": {
                        "@type": "EntryPoint",
                        "urlTemplate": "<?php echo Yii::$app->request->getHostInfo()
                        . Url::to(['/search']); ?>?q={search_term_string}"
                    },
                    "query-input": {
                        "@type": "PropertyValueSpecification",
                        "valueRequired": "http://schema.org/True",
                        "valueName": "search_term_string"
                    }
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
use yii\widgets\Breadcrumbs;


$leftSidebar = ThemeParts::renderPart('left-sidebar');
$rightSidebar = ThemeParts::renderPart('right-sidebar');
$contentLength = 12;
$leftSidebarLength = 3;
$rightSidebarLength = 3;

if (empty($leftSidebar) === false) {
	$contentLength -= $leftSidebarLength;
}
if (empty($rightSidebar) === false) {
	$contentLength -= $rightSidebarLength;
}

?>

<main>
	<?php //echo ThemeParts::renderPart('before-content') ?>
	<div class="container">
		<div class="row">
			<?php if (!empty($leftSidebar)) : ?>
				<div class="left-sidebar col-lg-<?= $leftSidebarLength ?> col-12">
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

					<?= $leftSidebar ?> 
				</div>
			<?php endif; ?>

			<div class="content-part col-md-<?= $contentLength?> col-xs-12">
				<?=
				Breadcrumbs::widget(
					[
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						'options' => [
							'itemprop' => "breadcrumb",
							'class' => 'breadcrumb d-lg-block d-sm-none d-none fade',
						]
					]
				)
				?>
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
</main>



<?= ThemeParts::renderPart('pre-footer') ?>
<?= ThemeParts::renderPart('footer') ?>
<?= ThemeParts::renderPart('post-footer') ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage();?>
