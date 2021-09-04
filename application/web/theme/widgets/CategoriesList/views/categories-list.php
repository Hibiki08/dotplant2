<?php
/** @var string $type */
/** @var string $header  */
/** @var integer $rootCategoryId */
/** @var integer $categoryGroupId */
/** @var boolean $displayHeader */
/** @var boolean $isInSidebar */
/** @var string $activeClass */
/** @var boolean $activateParents */
/** @var string $activeClass */
/** @var boolean $activateParents */

use yii\helpers\Html;
use app\web\theme\widgets\MenuTree;

$uri = $_SERVER['REQUEST_URI'];
$uriElems = explode('/', $uri);
if (preg_match('/catalog/', $uri) && count($uriElems) < 4) {
    $open = 1;
} else {
    $open = 0;
}

echo MenuTree::widget([
    'start' => 1,
    'closer' => $open,
    'table' => 'category',
    'order' => '`sort_order` ASC',
    'title_field' => 'h1',
    'link' => 'slug']
);

/*
$sidebarClass = $isInSidebar ? 'sidebar-widget' : '';
echo '<div class="categories-list ' . $sidebarClass . '">';

if ($displayHeader === true) {
    ?>
    <div class="widget-header">
        <?= $header ?>
    </div>
    <?php
}

if ($type === 'plain') {
    echo \app\widgets\PlainCategoriesWidget::widget([
        'root_category_id' => $rootCategoryId,
        'activeClass' => $activeClass,
        'activateParents' => $activateParents
    ]);
} elseif ($type === 'tree') {
    echo \app\modules\shop\widgets\CategoriesList::widget([
        'rootCategory' => $rootCategoryId,
        'activeClass' => $activeClass,
        'activateParents' => $activateParents
    ]);
}

echo '</div>';
*/