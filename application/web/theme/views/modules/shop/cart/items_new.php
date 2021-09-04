<?php
/**
 * @var \app\modules\shop\models\Order $model
 * @var \app\modules\shop\models\OrderItem[] $items
 * @var \yii\web\View $this
 */

use app\modules\shop\models\Product;
use kartik\helpers\Html;

$immutable = isset($immutable) && $immutable;

$subItems = [];
foreach ($items as $i => $item) {
    if ($item->parent_id != 0) {
        if (isset($subItems[$item->parent_id])) {
            $subItems[$item->parent_id][] = $item;
        } else {
            $subItems[$item->parent_id] = [$item];
        }
        unset($items[$i]);
    }
}

?>
<div class="row">
    <div class="col-lg-12 col-12">
        <div class="shop-cart__wrapper">
            <?php foreach ($items as $item): ?>
                <?php $itemUrl = \yii\helpers\Url::to([
                                    '/shop/product/show',
                                    'model' => $item->product,
                                    'category_group_id' => $item->product->category->category_group_id,
                                ]); ?>
                <div class="shop-cart__item d-flex flex-wrap flex-xl-row flex-md-row flex-xs-column flex-column align-items-center justify-content-around justify-content-lg-around justify-content-sm-start">
                    <div class="shop-cart__item-thumbnail">
                        <?= Html::a(
                            \app\modules\image\widgets\ObjectImageWidget::widget([
                                'limit' => 1,
                                'model' => $item->product,
                            ])
                            , $itemUrl);
                        ?>
                    </div>
                    <div class="shop-cart__item-title">
                        <?= Html::a(Html::encode($item->entity->getName()), $itemUrl); ?>
                    </div>
                    <div class="shop-cart__divider"></div>
                    <div class="shop-cart__item-price">
                        <?=
                        $mainCurrency->format(
                            $item->price_per_pcs
                        )
                        ?>
                    </div>
                    <div class="shop-cart__item-qty">
                        <?php if ($immutable === true): ?>
                            <?= $item->quantity ?>
                        <?php else: ?>


                            <div class="form-inline">
                                <div class="form-group">
                                    <div class="btn-group">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="qty-input">
                                                <i class="minus" data-action="change-quantity">-</i>
                                                <input class="quantity" placeholder="1" data-type="quantity" data-id="<?= $item->id ?>" type="number" 
                                                    value="<?= $item->quantity ?>" name="1" min="1" max="999" data-nominal="<?= $item->product->measure->nominal ?>"/>
                                                <i class="plus" data-action="change-quantity">+</i>
                                            </div>
                                        </div>
                                        <?php /*
                                        <input class="form-control quantity" 
                                            style="float: left; margin-right: -2px; max-width:80px;" 
                                            placeholder="1" size="16" type="text" 
                                            data-type="quantity" data-id="<?= $item->id ?>" 
                                            value="<?= $item->quantity ?>" data-nominal="<?= $item->product->measure->nominal ?>" />
                                       
                                        <button class="btn btn-primary minus" type="button" data-action="change-quantity">
                                            <i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary plus" type="button" data-action="change-quantity">
                                            <i class="fa fa-plus"></i></button>
                                        
                                        <button class="btn btn-danger" type="button" data-action="delete" data-id="<?= $item->id ?>" data-url="<?= \yii\helpers\Url::toRoute([
                                            'delete',
                                            'id' => $item->id
                                        ]) ?>"><i class="fa fa-trash-o"></i></button>
                                        */ ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="shop-cart__item-ammount">
                        <span class="item-price">
                            <?php
                            if ($item->discount_amount > 0) {
                                echo Html::tag('span',
                                    $mainCurrency->format(
                                        $item->total_price_without_discount
                                    ),
                                    [
                                        'style' => 'text-decoration: line-through;'
                                    ]
                                ).'<br>';
                            }
                            ?>

                            <?=
                            $mainCurrency->format(
                                $item->total_price
                            )
                            ?>
                        </span>
                    </div>
                    <div class="shop-cart__item-remove">
                        <a href="#" class="btn btn-danger" type="button" data-action="delete" data-id="<?= $item->id ?>" data-url="<?= \yii\helpers\Url::toRoute([
                                'delete',
                                'id' => $item->id
                            ]) ?>">Удалить </i>
                        </a>
                    </div>
                </div>
                <?php if (isset($subItems[$item->product_id])): ?>
                    <?=
                        $this->render(
                            'sub-items',
                            [
                                'mainCurrency' => $mainCurrency,
                                'model' => $model,
                                'immutable' => $immutable,
                                'items' => $subItems[$item->product_id],
                            ]
                        )
                    ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php foreach($model->specialPriceObjects as $object): ?>
                <div class="shipping-data shop-cart__item d-flex flex-wrap flex-xl-row flex-md-row flex-xs-column flex-column align-items-center justify-content-around justify-content-lg-around justify-content-sm-start">
                    <td colspan="4"><?= $object->name ?></td>
                    <td><?= $mainCurrency->format($object->price) ?></td>
                </div>
            <?php endforeach; ?>


            
        </div>
    </div>
</div>
<style>
@media print {
    header, .header, footer, .footer, .quantity {
        display: none;
    }

    input[data-type=quantity] {
        border: none;
        width: 100px;
    }
}
</style>