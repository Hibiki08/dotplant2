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
<?php

use app\widgets\Alert;
use yii\widgets\Breadcrumbs;



?>

<main>
	<?php //echo ThemeParts::renderPart('before-content') ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-12">
				<?=
				Breadcrumbs::widget(
					[
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
						'options' => [
							'itemprop' => "breadcrumb",
							'class' => 'breadcrumb catalog',
						]
					]
				)
				?>
				<?= Alert::widget() ?>
				<!-- content -->
				<?= $content ?>
				<!-- content end-->
			</div> <!-- content-part end 1 -->
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
