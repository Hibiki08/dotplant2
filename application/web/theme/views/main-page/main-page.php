<?php

use yii\helpers\Html;
use app\web\theme\widgets\MenuTree;
use app\web\theme\widgets\categoryRand;

/*
 * As you can see this is just a simple yii2 view file with several additional variables available
 *
 * For content rendering use $this->blocks!
 */

/**
 * @var \app\components\WebView $this
 * @var $breadcrumbs array
 * @var $model \app\modules\page\models\Page
 */
$this->params['breadcrumbs'] = $breadcrumbs;


// we need id of property that is related to todays-deals
// in production it is better to fill it statically in your template for better performance
$salePropertyId = \app\models\Property::getDb()->cache(function($db) {
    return \app\models\Property::find()->where(['key' => 'sale'])->select('id')->scalar($db);
}, 86400, new \yii\caching\TagDependency([
    'tags' => [
        \devgroup\TagDependencyHelper\ActiveRecordHelper::getCommonTag(\app\models\Property::className())
    ]
]));

$newestId = \app\models\Property::getDb()->cache(function($db) {
    return \app\models\Property::find()->where(['key' => 'todays_deals'])->select('id')->scalar($db);
}, 86400, new \yii\caching\TagDependency([
    'tags' => [
        \devgroup\TagDependencyHelper\ActiveRecordHelper::getCommonTag(\app\models\Property::className())
    ]
]));

?>

<div class="">
    <div class="row">
        <div class="col-lg-3 col-12">
            <?= MenuTree::widget([
                    'start' => 1,
                    'closer' => 1,
                    'table' => 'category',
                    'order' => '`sort_order` ASC',
                    'title_field' => 'h1',
                    'link' => 'slug']
                )
                ?>
        </div>
        <div class="col-lg-9 col-12">
            <div class="fade">

                <a href="/sale" class="category__title-hot text-xl-left text-sm-center text-center">
                    <img class="badge-img" src="/theme/dist/img/icons/sale-badge.svg" width="30" height="30" alt="Выгодные предложения" />
                    <h2>Выгодные предложения</h2>
                </a>

                <div class="category__body">
                    <div class="owl-carousel owl-carousel-one owl-theme container p-0">
                        <?php if (intval($salePropertyId) > 0): ?>
                        <?= \app\widgets\ProductsWidget::widget([
                                    'category_group_id' => 1,
                                    'values_by_property_id' => [
                                        $salePropertyId => [1]
                                    ],
                                    'limit' => 10,
                                    'itemView' => '@app/web/theme/views/modules/shop/product/carousel-item',
                            ]) ?>
                        <?php endif;?>
                    </div>
                </div>

            </div>

            <div class="fade">

                <div class="category__title-hot text-xl-left text-sm-center text-center ml-3">
                    <img class="badge-img" src="/theme/dist/img/icons/new-badge.svg" width="30" height="30" alt="Новые поступления" />
                    <h2>Новые поступления</h2>
                </div>

                <div class="category__body">
                    <div class="owl-carousel owl-carousel-one owl-theme container p-0">
                        <?php if (intval($newestId) > 0): ?>
                        <?= \app\widgets\ProductsWidget::widget([
                                    'category_group_id' => 1,

                                    //Добавляет предфильтрованную страницу (создается и настраивается в админке)
                                    //'values_by_property_id' => [
                                    //    $newestId => [1]
                                    //],

                                    //сортировка по времени добавления продукта
                                    'force_sorting' => [
                                        'date_added' => SORT_DESC,
                                    ],
                                    'limit' => 10,
                                    'itemView' => '@app/web/theme/views/modules/shop/product/carousel-item',
                            ]) ?>
                        <?php endif;?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
    $slider = \app\models\Slider::find()->where(['code' => 'mp_action_slider'])->one();
    if ($slider) {
    $sliderParams = json_decode($slider->params, true);
    if ($sliderParams) {
        $speed = $sliderParams['interval'] ? (int)$sliderParams['interval'] : null;
    }
    ?>

    <div class="owl-carousel owl-carousel-benefits owl-theme container p-0" <?= isset($speed) ? 'data-speed="' . $speed . '"' : '' ?>>
        <?php foreach ($slider->getSlides(true) as $slide) {
            /** @var \app\models\Slide $slide */ ?>
            <div class="item">
                <a href="<?= $slide->link ?>">
                    <span class="benefits__wrapper d-flex justify-content-center align-items-center">
                        <img src="<?= $slide->image ?>" alt="">
                        <span class="benefits__item">
                            <span class="d-flex flex-column justify-content-center align-items-center">
                                <i class="<?= $slide->css_class ? $slide->css_class : '' ?> p-2"></i>
                                <?= $slide->text ?>
                            </span>
                        </span>
                    </span>
                </a>
            </div>
        <?php } ?>
    </div>

    <?php } ?>

    <?php
        $numCats = 5;
        $cat = json_decode(categoryRand::widget(['numCats' => $numCats]));
        for ($m=0; $m<$numCats; $m++) {
            if(isset($cat[$m])) {
                echo $this->render('category-slider', ['categorySlug' => trim($cat[$m])]);
            }
        }
    ?>

</div>

<?php
/*
    <div class="row">
        <div class="col-md-12">
            <?= isset($this->blocks['content']) ? $this->blocks['content'] : 'Empty content - edit it in backend/page section' ?>
        </div>
    </div>
    */ 
?>
