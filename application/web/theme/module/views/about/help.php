<?php

$this->title = Yii::t('app', 'Помощь');

$this->params['breadcrumbs'] = [
    $this->title,
];

?>

<div class="page__title text-xl-left text-sm-center text-center d-lg-block d-sm-none d-none fade">
    <h1><?= $this->title ?></h1>
</div>

<div class="container p-0 d-flex flex-md-row flex-xs-column flex-column fade">
    <div>
        <h2 class="fade">Как оформить заказ</h2>
        <p class="fade">
            Если вы уверены в выборе, то можете самостоятельно оформить заказ, заполнив по этапам всю форму.
        </p>

        <h2 class="fade">Доставка</h2>
        <p class="fade">
            В зависимости от места жительства вам предложат варианты доставки. 
            Выберите любой удобный способ. Подробнее об условиях доставки читайте в разделе 
            <a href="/delivery"><span class="dotted colored">«Доставка»</span></a>.
        </p>
 
        <h2 class="fade">Оплата</h2>
        <p class="fade">
            Выберите оптимальный способ оплаты. Подробнее о всех вариантах читайте в разделе 
            <a href="/payment"><span class="dotted colored">«Оплата»</span></a>
        </p>
 
        <h2 class="fade">Покупатель</h2>
        <p class="fade">
            Введите данные о себе: ФИО, адрес доставки, номер телефона. 
            В поле «Комментарии к заказу» введите сведения, которые могут пригодиться курьеру, 
            например: подъезды в доме считаются справа налево.
        </p>
 
        <h2 class="fade">Оформление заказа</h2>
        <p class="fade">
            Проверьте правильность ввода информации: 
            позиции заказа, выбор местоположения, данные о покупателе. 
            Нажмите кнопку «Оформить заказ».
        </p>

    <div>
</div>