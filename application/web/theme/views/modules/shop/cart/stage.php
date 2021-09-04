<?php
/**
 * @var \app\modules\shop\models\OrderStage $stage
 * @var \yii\web\View $this
 * @var \app\modules\shop\models\Order $order
 */

use app\modules\shop\helpers\OrderStageHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$currency = \app\modules\shop\models\Currency::getMainCurrency();

$this->context->layout = '@app/web/theme/views/modules/basic/layouts/simple';

$this->title = 'Информация о Вас';
// todo вернуть перевод
// $this->title = Html::encode($stage->name_frontend);
?>
<div class="container">
    <div class="page__wrapper fade">

    <div class="page__title text-xl-left text-sm-center text-center fade"><i class="fas fa-truck"></i>
        <h1>Информация о Вас</h1>
        <?php
        // todo вернуть перевод
        // <h1><?= Html::encode($stage->name_frontend); ></h1>
        ?>
    </div>


<?php
$form = \yii\widgets\ActiveForm::begin([
    'id' => 'shop-stage',
    //'layout' => 'horizontal',
]);
$stageView = Yii::getAlias($stage->view);
if (is_file($stageView)) {
    $eventData = empty($eventData) ? [] : $eventData;
    echo $this->renderFile($stageView,
        array_merge($eventData, [
            'form' => $form,
            'stage' => $stage,
        ])
    );
}

?>
<div class="container p-0 fade mt-3">
    <div class="row">
        <div class="col-md-6 shop-cart__total-checkout d-flex align-items-center justify-content-between flex-lg-row flex-md-row flex-column previous-button">
            <?php if($stage->name == 'customer') :?>
                <?= Html::a('Обратно в корзину', ['/shop/cart'], ['class' => 'shop-cart__form-button', ]) ?>
            <?php else: ?>
                <?= array_reduce(
                    OrderStageHelper::getPreviousButtons($stage),
                    function ($result, $item) {
                        $result .= Html::a(Html::button($item['label'], [/*'data-action' => $item['url'],*/ 'class' => 'shop-cart__form-button', 'type' => 'button', ]), 
                            [ $item['url']]);
                        return $result;
                    },
                    ''
                ); ?>
            <?php endif; ?>
        </div>
        
        <div class="col-md-6 delivery-button" style="display: none;">
            <?php if ($order->items_count > 0): ?>
                <div class="shop-cart__delivery-button d-flex justify-content-md-end justify-content-sm-center justify-content-center align-items-center next-button">
                    <?php if($stage->name != 'payment') : ?>
                        <?=
                        array_reduce(
                            OrderStageHelper::getNextButtons($stage),
                            function ($result, $item) {
                                $result .= Html::submitButton($item['label'] . '<i class="fas fa-check ml-2"></i>', ['data-action' => $item['url'], 'class' => 'shop-cart__form-button checkout']);
                                return $result;
                            },
                            ''
                        );
                        ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="container d-flex align-items-center justify-content-around fade">
            <div class="step-container">
                <a href="<?= Url::to('/shop/cart') ?>">
                <div class="step done">
                    <div class="step-icon"><svg viewBox="0 0 16 16"><polyline fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" points="1,9 5,13 15,3 "></polyline></svg></div>
                    <div class="step-text"><span>Корзина</span></div>
                </div>
                </a>
                <div class="line active"></div>
                <div class="step active">
                    <div class="step-icon">2</div>
                    <div class="step-text"><span>Доставка</span></div>
                </div>

                <?php $stepClass =  ($stage->name == 'payment' ? 'active' : '' ); ?>
                <div class="line <?= $stepClass ?>"></div>
                <div class="step <?= $stepClass ?>">
                    <div class="step-icon">3</div>
                    <div class="step-text"><span>Оплата</span></div>
                </div>
                
                <div class="line"></div>
                <div class="step">
                    <div class="step-icon">4</div>
                    <div class="step-text"><span>Готово</span></div>
                </div>
            </div>
        </div>

    </div>
</div>
<?php
$form->end();
$js = <<<JS

        $('form#shop-stage button[type="submit"]').on('click', function(event) {
            event.preventDefault();
            $('form#shop-stage').attr('action', $(this).attr('data-action'));
            $('form#shop-stage').submit();
        });

JS;
$this->registerJs($js);
?>

<style>
    .list-stage-buttons li {
        list-style-type: none;
        padding: 5px 0;
    }
</style>
