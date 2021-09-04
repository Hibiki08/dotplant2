<?php

$this->title = Yii::t('app', 'Условия доставки');

$this->params['breadcrumbs'] = [
    $this->title,
];

?>

<div class="page__title text-xl-left text-sm-center text-center d-lg-block d-sm-none d-none fade">
    <h1><?= $this->title ?></h1>
</div>

<div class="container p-0 d-flex flex-md-row flex-xs-column flex-column fade">
    <div>
    <h2 class="fade">Курьерская доставка</h2>
    
    <p class="fade">
        Во всех городах России, от Калининграда до Владивостока. 
        Отправляем со склада, привозим двумя способами на выбор: 
        до ближайшего к покупателю пунктa выдачи заказов СДЭК или на дом курьером.
    </p>
    <p class="fade">Доставка за 2–5 дней, в зависимости от направления.</p>
    <p class="fade">Более 1300 пунктов выдачи, заказов по России</p>
    <p class="fade">6 000 курьеров, привезут посылки в удобное время</p>

    <h2 class="fade">Самовывоз со склада</h2>
    <p class="fade">
        Вы можете забрать товар в одном из магазинов, сотрудничающих с нами. 
        Список торговых точек есть в разделе
        <a href="/contacts"><span class="dotted colored">«Контакты»</span></a>.
    </p>

    <h2 class="fade">Почтовая доставка</h2>
    <p class="fade">
        Если в вашем городе не действует курьерская служба, 
        то вы можете заказать доставку через почту России. 
        Сразу по прибытии товара, на ваш адрес придет извещение о посылке.
    </p>
    <p class="fade">
        Вы можете оценить состояние коробки (не вскрывая): вес, целостность. 
        Если вам кажется, что заказ не соответствует параметрам или коробка повреждена, 
        попросите сотрудника почты составить акт о вскрытии. 
        Вскрывать коробку самостоятельно вы можете только после того, как оплатили заказ.
    </p>
    <p class="fade">Один заказ может содержать не больше 10 позиций.</p>

    <h2 class="fade">Срок доставки</h2>
    <p class="fade">
        В зависимости от вашего региона проживания, доставка занимает разное время.
    </p>

    <div class="fade">
        <table class="delivery-table">
            <thead>
                <tr class="text-center">
                    <td>Регион</td>
                    <td>Курьерская доставка</td>
                    <td>Самовывоз из магазина</td>
                    <td>Почта России</td>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>Московская область, Ленинградская область</td>
                    <td class="text-center" colspan=2>2 рабочих дня</td>
                    <td class="text-center">5 дней</td>
                </tr>

                <tr>
                    <td>Урал и Поволжье</td>
                    <td class="text-center">5-7 рабочих дней</td>
                    <td class="text-center">6-9 рабочих дней</td>
                    <td class="text-center">14 дней</td>
                </tr>

                <tr>
                    <td>Сибирь</td>
                    <td class="text-center">8-10 рабочих дней</td>
                    <td class="text-center">12 рабочих дней</td>
                    <td class="text-center">14-21 день</td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="fade"></p>


    </div>
</div>