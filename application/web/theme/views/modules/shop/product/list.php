<?php

/**
 * @var $breadcrumbs array
 * @var $category_group_id integer
 * @var $object \app\models\BaseObject
 * @var $pages \yii\data\Pagination
 * @var $products \app\modules\shop\models\Product[]
 * @var $selected_category \app\modules\shop\models\Category
 * @var $selected_category_id integer
 * @var $selected_category_ids integer[]
 * @var $selections
 * @var $this app\components\WebView
 * @var $title_append string
 * @var $values_by_property_id
 * @var $default_wish_list Wishlist|null
 */

use app\modules\shop\models\Category;
use \app\modules\shop\models\UserPreferences;
use app\modules\shop\models\Wishlist;
use app\widgets\city_text\TextByCity;
use app\widgets\SeoCityText\SeoCityText;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

$subCategories = Category::getByParentId($selected_category_id);

$this->params['breadcrumbs'] = $breadcrumbs;

if (empty($subCategories)) {
    $this->title = $this->blocks['h1'] . TextByCity::widget(['text' => ' купить в городе {city_name}', 'cityAttribute' => 'parental_case',]);
//    echo TextByCity::widget([
//        'text' => $this->blocks['h1'] . ' купить в городе {city_name}',
//        'cityAttribute' => 'parental_case',
//    ]);
} else {
    $this->title = $this->blocks['h1'];
}

$this->params['hideFilters'] = false;
?>
<div class="container" id="product-list-block">
    <div class="category__wrapper fade">
        <div class="category__title d-lg-block d-sm-none d-none text-xl-left text-sm-center text-center fade">
            <i class="fab fa-gratipay"></i>
            <h1><?= $this->blocks['h1'] ?></h1>
        </div>

        <?php if(!empty($subCategories)): ?>
            <?php $this->params['hideFilters'] = true; ?>
            <div class="container p-0 fade">
                <div class="row">
                <?php
                    foreach ($subCategories as $cat) {
                        echo $this->render('subcat', [
                            'category' => $cat,
                        ]);
                    }
                ?>
                </div>
            </div>
        <?php else: ?>

            <div class="category__list-options d-lg-flex d-sm-none d-none fade">
                <div class="category__list-options_sort">
                    <span>Сортировка:</span>
                    <div class="category__list-options_sort_wrapper">
                        <select id="js_cat_sort" class="category__list-options_sort-order">
                            <?php foreach($allSorts as $sortOpt):?>
                                <option 
                                    <?= $sortOpt['id'] == $sort ? 'selected="selected"' : ''?>
                                    value='<?= $sortOpt['id'] ?>' 
                                    data-url="<?= Url::current(['sort' => $sortOpt['id'],'page' => null]) ?>">
                                        <?= $sortOpt['name'] ?>
                                </option>
                            <?php endforeach;?>
                            <?php /*
                            <option value='name' data-url="<?= Url::current(['sort' => 'name']) ?>">Наименование (А-Я)</option>
                            <option value='-name' data-url="<?= Url::current(['sort' => '-name']) ?>">Наименование (Я-А)</option>
                            <option value='price' data-url="<?= Url::current(['sort' => 'price']) ?>">Цена (По-возрастанию)</option>
                            <option value='-price' data-url="<?= Url::current(['sort' => '-price']) ?>">Цена (По-убыванию)</option>
                            */
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="category__list-options_display">
                    <span>Вид:</span>
                    <div id="js_display" class="category__list-options_display_wrapper">
                        <div class="js_set category__list-options_display-grid <?= ($listDisplay == 'grid' ? 'active' : '') ?>" data-val="grid"><i class="fas fa-th-large"></i></div>
                        <div class="js_set category__list-options_display-list <?= ($listDisplay == 'grid' ? '' : 'active') ?>" data-val="list"><i class="fas fa-list"></i></div>
                    </div>
                </div>
                <div class="category__list-options_number">
                    <span>Количество:</span>
                    <div id="js_limit_set" class="category__list-options_number_wrapper">
                        <a href="<?= ($limit == 12 ? '#' : Url::current(['limit' => 12,'page' => null])) ?>" class="js_set category__list-options_number-qty <?= $limit == 12 ? 'active' : '' ?>">12</a>
                        <a href="<?= ($limit == 24 ? '#' : Url::current(['limit' => 24,'page' => null])) ?>" class="js_set category__list-options_number-qty <?= $limit == 24 ? 'active' : '' ?>">24</a>
                        <a href="<?= ($limit == 48 ? '#' : Url::current(['limit' => 48,'page' => null])) ?>" class="js_set category__list-options_number-qty <?= $limit == 48 ? 'active' : '' ?>">48</a>
                    </div>
                </div>
            </div>
            <!-- filters mobile -->

            <div class="filters__mobile-menu row no-gutters d-lg-none d-sm-flex d-flex align-items-center mb-3">
                <div class="col-6 text-center">
                    <a href="#"><div class="filters__mobile-filter-button">Фильтровать по</div></a>
                </div>
                <div class="col-6 text-center">
                    <a href="#"><div class="filters__mobile-sort-button">Сортировать по <i class="fa fa-chevron-down"></i></div></a>
                </div>
                <div class="filters__mobile-sort-menu" style="display:none">
                    <div class="filters__mobile-sort-menu_inner">
                        <?php foreach($allSorts as $sortOpt):?>
                            <a href="<?= Url::current(['sort' => $sortOpt['id'],'page' => null]) ?>">
                                <div class="filters__mobile-sort-menu_option"><?= $sortOpt['name'] ?></div>
                            </a>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
            <?php /*
            <div class="filters__mobile-filter-menu">
                <div class="filters__mobile-filter-menu-inner">

                    <ul class="filter-menu">
                        <li class="actions">
                            <div class="close-filter"></div>
                            <a href="#"><div class="reset-filter">Сбросить фильтры</div></a>
                        </li>

                        <li>
                            <a href="#" class="filter-has-submenu">Тип памяти</a>
                            <ul class="filter-submenu">
                                <li class="filter-back">
                                    <a href="#">Отмена</a>
                                    <a href="#"><div class="reset-filter">Сбросить фильтры</div></a>
                                </li>
                                <div class="filters__mobile-property-container">
                                    <div class="filters__mobile-property-name">Тип памяти</div>
                                    <div class="property-values p-0">
                                        <label class="chk-container">DDR3
                                            <input type="checkbox" id="filter-check-3" class="filter-check filter-check-property-18" name="properties[18][]" value="3" data-property-id="18">
                                            <span class="chk-mark filter-link" data-selection-id="3" data-property-id="18"></span>
                                        </label>
                                        <label class="chk-container">DDR3 / DDR3L
                                            <input type="checkbox" id="filter-check-15" class="filter-check filter-check-property-18" name="properties[18][]" value="15" data-property-id="18">
                                            <span class="chk-mark filter-link" data-selection-id="15" data-property-id="18"></span>
                                        </label>
                                        <label class="chk-container">DDR3L
                                            <input type="checkbox" id="filter-check-10" class="filter-check filter-check-property-18" name="properties[18][]" value="10" data-property-id="18">
                                            <span class="chk-mark filter-link" data-selection-id="10" data-property-id="18"></span>
                                        </label>
                                        <label class="chk-container">LPDDR3
                                            <input type="checkbox" id="filter-check-7" class="filter-check filter-check-property-18" name="properties[18][]" value="7" data-property-id="18">
                                            <span class="chk-mark filter-link" data-selection-id="7" data-property-id="18"></span>
                                        </label>
                                    </div>
                                    <div class="d-flex justify-content-center py-3">
                                        <button type="submit" class="filter-button">Показать результаты</button>
                                    </div>
                                </div>

                            </ul>
                        </li>

                        <li>
                            <a href="#" class="filter-has-submenu">Тип экрана</a>
                            <ul class="filter-submenu">
                                <li class="filter-back">
                                    <a href="#">Отмена</a>
                                    <a href="#"><div class="reset-filter">Сбросить фильтры</div></a>
                                </li>
                                <div class="filters__mobile-property-container">
                                    <div class="filters__mobile-property-name">Тип экрана</div>
                                    <div class="property-values">
                                        <label class="chk-container">Глянцевый
                                            <input type="checkbox" id="filter-check-79" class="filter-check filter-check-property-116" name="properties[116][]" value="79" data-property-id="116">
                                            <span class="chk-mark filter-link" data-selection-id="79" data-property-id="116"></span>
                                        </label>

                                        <label class="chk-container">Матовый
                                            <input type="checkbox" id="filter-check-28" class="filter-check filter-check-property-116" name="properties[116][]" value="28" data-property-id="116">
                                            <span class="chk-mark filter-link" data-selection-id="28" data-property-id="116"></span>
                                        </label>

                                        <label class="chk-container">Матовый / Глянцевый
                                            <input type="checkbox" id="filter-check-16" class="filter-check filter-check-property-116" name="properties[116][]" value="16" data-property-id="116">
                                            <span class="chk-mark filter-link" data-selection-id="16" data-property-id="116"></span>
                                        </label>
                                    </div>
                                    <div class="d-flex justify-content-center py-3">
                                        <button type="submit" class="filter-button">Показать результаты</button>
                                    </div>
                                </div>
                            </ul>
                        </li>

                        <li>
                            <a href="#" class="filter-has-submenu">Тип матрицы</a>
                            <ul class="filter-submenu">
                                <li class="filter-back">
                                    <a href="#">Отмена</a>
                                    <a href="#"><div class="reset-filter">Сбросить фильтры</div></a>
                                </li>
                                <div class="filters__mobile-property-container">
                                    <div class="filters__mobile-property-name">Тип матрицы</div>
                                    <div class="radio-container">
                                        <input class="radio-input" name="screen" type="radio" id="IPS">
                                        <label class="radio-label" for="IPS">IPS</label>
                                    </div>
                                    <div class="radio-container">
                                        <input class="radio-input" name="screen" type="radio" id="TFT">
                                        <label class="radio-label" for="TFT">TFT</label>
                                    </div>

                                    <div class="d-flex justify-content-center py-3">
                                        <button type="submit" class="filter-button">Показать результаты</button>
                                    </div>
                                </div>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
            */ ?>
            <!-- filters mobile end -->

            <?php //Pjax::begin(); ?>
            <div class="container category__list p-0 fade">
                <div class="row">
                    
                    <?php foreach ($products as $product) {
                        if ($this->beginCache('Product-item:' . $product->id, [
                            'duration' => 86400,
                            'dependency' => new \yii\caching\TagDependency([
                                'tags' => $product->getCacheTags(),
                            ])
                        ])) {
                            $url = Url::to(
                                [
                                    '@product',
                                    'model' => $product,
                                    'category_group_id' => $category_group_id,
                                ]
                            );

                            echo $this->render('item',
                                [
                                    'product' => $product,
                                    'url' => $url,
                                    'default_wish_list' => $default_wish_list,
                                    'listDisplay' => $listDisplay,
                                ]);
                            $this->endCache();
                        }
                    } ?>
                    

                </div>
                <nav>
                    <div class="pagination w-100 text-center">
                        <ul id="js__pagination" class="pagination">
                            <?php if ($pages->pageCount > 1): ?>
                                <?php 
                                    //$_GET = $requestParams;
                                    //$pages->params = $requestParams;
                                ?>
                                <?= \justinvoelker\separatedpager\LinkPager::widget([
                                    'pagination' => $pages,
                                    'maxButtonCount'=> 7,
                                ]); ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </nav>
            </div>
            <?php //Pjax::end(); ?>
        <?php endif; ?>
        <div class="category__list-options d-lg-flex d-sm-none d-none fade qwerty">
            <?= SeoCityText::widget([
                'categoryId' => $selected_category_id,
                'isCategory' => true,
            ]); ?>
        </div>
    </div>
</div>
