<?php

/**
 * @var $error integer
 * @var $message string
 * @var $object \app\models\BaseObject
 * @var $products \app\modules\shop\models\Product[]
 * @var $this \yii\web\View
 */

// todo вернуть перевод
// $this->title = Yii::t('app', 'Products comparison');
$this->title = Yii::t('app', 'Сравнение товаров');

?>
<div class="container">
    <div class="page__wrapper fade">
        <div class="page__title text-xl-left text-sm-center text-center fade">
            <i class="far fa-chart-bar"></i>
            <?php
            // todo вернуть перевод
            // <h1><?= Yii::t('app', 'Products comparison') ></h1>
            ?>
            <h1><?= Yii::t('app', 'Сравнение товаров') ?></h1>
        </div>
        <div class="container p-0 fade">
            <div class="compare-page__wrapper">
                <div class="compare-page__table">
                    <?php
                    if (isset($error) && $error) {
                        echo $message;
                    } else {
                        echo \app\modules\shop\widgets\ProductCompare::widget();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
