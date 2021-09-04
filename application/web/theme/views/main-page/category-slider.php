<?php 
    use app\modules\shop\models\Category;
    $category = Category::find()->where(['slug' => $categorySlug])->one();
?>
<?php if($category) :?>
    <?php $url = '/' . $category->getUrlPath() ?>
    <div class="container">
        <div class="category__wrapper fade">
            <a href="<?= $url ?>" class="category__title text-xl-left text-sm-center text-center pl-3">
                <i class="fab fa-gratipay"></i> <?php //TODO: make svg or/and icon property in Category model ?>
                <h2><?= $category->name ?></h2>
            </a>
            <div class="category__body">
                <div class="owl-carousel owl-carousel-two owl-theme container p-0">
                    <?= \app\widgets\ProductsWidget::widget([
                                            'category_group_id' => 1,
                                            'selected_category_id' => $category->id,
                                            'limit' => 12,
                                            'itemView' => '@app/web/theme/views/modules/shop/product/carousel-item',
                                        ]) ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>

<?php endif;?>