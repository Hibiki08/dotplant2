<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;

/**
 * @var \yii\web\View $this
 * @var \app\modules\shop\models\Product[]|array $products
 */

$properties = array_reduce($products,
    function ($result, $item) {
        /** @var \app\modules\shop\models\Product|\app\properties\HasProperties $item */
        /** @var \app\properties\AbstractModel $model */
        $model = $item->getAbstractModel();
        foreach ($model->attributes() as $attr) {
            $result[$attr] = $model->getAttributeLabel($attr);
        }
        return $result;
    },
    []);
$blank = array_fill_keys(array_keys($properties), '');
$compares = [];
?>



<?php
foreach ($products as $key => $item) {
    $column = $blank;
    /** @var \app\modules\shop\models\Product|\app\properties\HasProperties $item */
    /** @var \app\properties\AbstractModel $model */
    $model = $item->getAbstractModel();
    foreach ($model->attributes() as $attr) {
        $column[$attr] = $model->getPropertyValueByAttribute($attr);
    }
    $compares[] = $column;
}
?>
<table class="table table-striped table-hover table-condensed table-bordered">
    <thead>
    <tr>
        <th></th>
        <?php foreach ($products as $key => $item) { ?>
            <th>
                <?= app\modules\image\widgets\ObjectImageWidget::widget([
                    'viewFile' => '@webroot/theme/views/modules/shop/widgets/views/product-compare/img-tpl',
                    'model' => $item,
                    //'thumbnailOnDemand' => true, //todo понять почему php не видит файлы. Из за этого placeholder выводится
                    'thumbnailWidth' => 180,
                    'thumbnailHeight' => 180,
                    'limit' => 1,
                    'additional' => [
                        'blank' => '/theme/dist/images/no-image.png',
                    ]
                ]); ?>
                <a href="<?= Url::to([
                    'product/show',
                    'model' => $item,
                    'last_category_id' => $item->main_category_id,
                    'category_group_id' => $item->category->category_group_id,
                ]) ?>">
                    <div class="compare-page__table-title"><?= Html::encode($item->name) ?></div>
                </a>
                <div class="compare-page__table-price"><?= $item->nativeCurrencyPrice(false, false) ?></div>
                <div class="row no-gutters">
                    <div class="col align-self-center">
                        <a href="#" data-action="add-to-cart">
                            <div class="compare-page__table-add-cart" data-product-id="<?= $item->id ?>">
                                <i class="fa fa-shopping-cart"></i> В корзину
                            </div>
                        </a>
                    </div>
                    <div class="col align-self-center">
                        <a href="<?= Url::toRoute([
                            '/shop/product-compare/remove', 'id' => $item->id,
                            'backUrl' => Yii::$app->request->url,
                        ])?>">
                            <div class="compare-page__table-remove">
                                <i class="fas fa-trash-alt"></i>Удалить
                            </div>
                        </a>
                    </div>
                </div>
            </th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($properties as $key => $prop) {
        $_flag = false;
        $result = '<tr><th>' . $prop . '</th>';
        $result .= array_reduce(array_column($compares, $key),
            function ($result, $item) use (&$_flag) {
                if (!empty(strval($item))) {
                    $_flag = true;
                }
                $result .= '<td>' . $item . '</td>';
                return $result;
            },
            '');
        $result .= '</tr>' . PHP_EOL;
        if ($_flag) {
            echo $result;
        }
    } ?>
    </tbody>
</table>
