<?php

use app\components\delivery\sdek\SdekDelivery;

?>

<?php $deliveryPrice = SdekDelivery::getInfo($orderDeliveryInformation->order->items, $cityCode, $orderDeliveryInformation, $isPickup); ?>

<?php foreach($deliveryPrice as $key => $text): ?>
    <div class="subtitle <?= ($key == 'error' ? 'error' : '') ?>">
        <?php if($key == 'period'): ?>
            <i class="far fa-clock"></i>
        <?php endif; ?>
        <?= $text ?> <?= ($key == 'price' ? 'руб.' : '') ?>

        <?php $selector = ($isPickup ? '.js__pickup_select' : '.js__curier_select'); ?>
        <script>
            <?php if($key == 'error') : ?>
                $('<?= $selector ?>').addClass('disabled');
            <?php else: ?>
                $('<?= $selector ?>').removeClass('disabled');
            <?php endif; ?>
        </script>
        
    </div>
<?php endforeach; ?>