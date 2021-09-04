<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
/** @var app\components\WebView $this */
/** @var bool $useFontAwesome */
/** @var \app\extensions\DefaultTheme\Module $theme */
/** @var integer $rootNavigationId */
?>
</div>
<footer class="page-footer footer">
    <div class="container">
        <div class="row">
                    <div class="col-xl-4 col-md-4 col-xs-6 col-6">
                        <div class="footer-item__wrapper">
                            <div class="footer-item__header">Компания</div>
                            <div class="footer-item__content"><ul>
                                <li><a href="/about">О компании</a></li>
                                <li><a href="/partners">Партнеры</a></li>
                                <li><a href="/contacts">Контакты</a></li>
                             </ul>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-xl-4 col-md-4 col-xs-6 col-6">
                        <div class="footer-item__wrapper">
                            <div class="footer-item__header">Покупателям</div>
                            <div class="footer-item__content"><ul>
                                <li><a href="/shop/cabinet">Личный кабинет</a></li>
                                <li><a href="/catalog">Каталог</a></li>
                                <li><a href="/delivery">Условия доставки</a></li>
                                <li><a href="/payment">Условия оплаты</a></li>
                                <li><a href="/help">Помощь</a></li>
                             </ul>
                            </div>
                        </div>
                    </div>                   
                    <div class="col-xl-4 col-md-4 col-xs-12 col-12 footer-social-mobile">
                        <div class="footer-item__wrapper">
                            <div class="footer-item__header text-xl-right text-md-right text-xs-center text-center">Мы в соцсетях</div>
                            <div class="footer-item__social d-flex flex-row justify-content-xl-end justify-content-md-end justify-content-xs-center justify-content-center">
                                <ul class="d-flex flex-row">
                                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fab fa-vk"></i></a></li>
                                    <li><a href="#"><i class="fab fa-odnoklassniki"></i></a></li>
                                    <li><a href="#"><i class="fab fa-instagram"></i> </a></li>
                                </ul>
                            </div>
                        </div>
                </div>
        </div>
                <hr>
                <div class="row">
                    <div class="col-xl-12 d-flex flex-xl-row flex-md-row flex-xs-column flex-column align-items-center justify-content-between footer-item__pay">
                        <div class="footer-item__copyright text-xl-left text-md-left text-xs-center text-center">© 2020 «SexToys365» — Интернет-магазин</div>
                        <div class="footer-item__pay">
                            <img src="/theme/images/icons/visa-logo.svg" alt="Visa">
                            <img src="/theme/images/icons/mastercard-logo.svg" alt="Mastercard">
                            <img src="/theme/images/icons/mir-logo.svg" alt="Мир">
                        </div>
                    </div>
                </div>
            <?php /*
            <div class="col-md-12 footer">
                <?=
                    \app\widgets\navigation\NavigationWidget::widget([
                        'rootId' => $rootNavigationId,
                    ])
                ?>
            </div>
            */ ?>
    </div>
</footer>

    <div id="19plus-modal" style="display: none; max-width: 400px; text-align: center">
        <div class="row">
            <img style="width: 50%; margin: 5px auto" src="data:image/svg+xml;utf8;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxODYuOTQgMTk5LjcxIj48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6I2Q0MDAwMDt9LmNscy0ye2ZpbGw6I2ZmZjt9PC9zdHlsZT48L2RlZnM+PGcgaWQ9IkxheWVyXzIiIGRhdGEtbmFtZT0iTGF5ZXIgMiI+PGcgaWQ9InN2ZzIiPjxwYXRoIGlkPSJwYXRoMjM4NCIgY2xhc3M9ImNscy0xIiBkPSJNMTg2Ljk0LDk5Ljg2YzAsNTUuMTUtNDEuODQsOTkuODUtOTMuNDcsOTkuODVTMCwxNTUsMCw5OS44Niw0MS44NSwwLDkzLjQ3LDAsMTg2Ljk0LDQ0LjcxLDE4Ni45NCw5OS44NloiLz48cGF0aCBpZD0idGV4dDMxNTYiIGNsYXNzPSJjbHMtMiIgZD0iTTQ2LjgyLDE0Ny42MUgzMS4yMVY3Ny4xMkE1Mi44Myw1Mi44MywwLDAsMSwxMSw5MS4zdi0xN3E2LjEtMi40LDEzLjI4LTkuMDlhMzQuNywzNC43LDAsMCwwLDkuODQtMTUuNkg0Ni44MlpNODMuNjIsOTVhMTkuMjcsMTkuMjcsMCwwLDEtOC44MS04LjQyQTI1LjM1LDI1LjM1LDAsMCwxLDcyLjA2LDc0LjhxMC0xMC45Miw2LjM2LTE4dDE4LjEtNy4xMnExMS42MSwwLDE4LDcuMTJ0Ni40MiwxOEEyNC40NywyNC40NywwLDAsMSwxMTgsODYuODgsMTkuOSwxOS45LDAsMCwxLDEwOS43NSw5NWEyMywyMywwLDAsMSwxMC4zMSw5LjUyLDI4LjkzLDI4LjkzLDAsMCwxLDMuNTMsMTQuNDRxMCwxMy41Mi03LjIsMjJ0LTE5LjE1LDguNDVxLTExLjExLDAtMTguNTEtN1E3MCwxMzQuMSw3MCwxMTkuNzJhMzIuNCwzMi40LDAsMCwxLDMuMjgtMTQuNTRBMjIuNTYsMjIuNTYsMCwwLDEsODMuNjIsOTVabTMuMjItMTguODNxMCw1LjU4LDIuNjQsOC43MmE5LjU0LDkuNTQsMCwwLDAsMTQuMTUsMGMxLjc4LTIuMTEsMi42Ny01LDIuNjctOC43NWExMi43MSwxMi43MSwwLDAsMC0yLjY0LTguNDIsOC42NCw4LjY0LDAsMCwwLTctMy4xNiw4Ljg2LDguODYsMCwwLDAtNy4xNywzLjE5LDEyLjc2LDEyLjc2LDAsMCwwLTIuNjcsOC40NlptLTEuNDQsNDEuOHEwLDcuNzEsMy4zMSwxMkExMCwxMCwwLDAsMCw5NywxMzQuM2E5LjY4LDkuNjgsMCwwLDAsOC00LjE2cTMuMTgtNC4xNSwzLjE3LTEyLDAtNi44NS0zLjIyLTExQTkuOTMsOS45MywwLDAsMCw5Ni43NCwxMDNhOS4yNiw5LjI2LDAsMCwwLTguNTMsNC43MywxOS43MSwxOS43MSwwLDAsMC0yLjgxLDEwLjI1WiIvPjxwb2x5bGluZSBpZD0icG9seWxpbmUyODEiIGNsYXNzPSJjbHMtMiIgcG9pbnRzPSIxNDguMDggMTMwLjA4IDE0OC4wOCAxMDQuNzggMTI0LjM5IDEwNC43OCAxMjQuMzkgOTIuMzYgMTQ4LjA4IDkyLjM2IDE0OC4wOCA2Ny4wNiAxNTkuNyA2Ny4wNiAxNTkuNyA5Mi4zNiAxODMuMzkgOTIuMzYgMTgzLjM5IDEwNC43OCAxNTkuNyAxMDQuNzggMTU5LjcgMTMwLjA4IDE0OC4wOCAxMzAuMDgiLz48L2c+PC9nPjwvc3ZnPg==" />
            <div class="col-md-12">
                <h2>Только для взрослых</h2>
            </div>
        </div>
        <div class="row" style="text-align: center">
            <div class="col-md-6 col-xs-6">
                <a href="#s" onclick="$.fancybox.close()" class="form-button" style="max-width: 120px; margin: 5px auto">Остаться</a>
            </div>
            <div class="col-md-6 col-xs-6">
                <a href="https://yandex.ru/video/?utm_source=main_stripe_big" class="form-button" style="max-width: 120px; margin: 5px auto">Покинуть</a>
            </div>
        </div>
    </div>

    <a data-fancybox="18Plus" id="18Plus" data-src="#19plus-modal" href="#m"></a>
<?php
$js = <<<JS
    $(document).ready(function(){
        $('[data-fancybox="18Plus"]').fancybox({
            'modal' : true,
        });
        
        var LS_KEY = 'modal_shown';
  
        // Если модал еще не открыали
        if (!localStorage.getItem(LS_KEY)) {
            setTimeout(function(){
                $('#18Plus').click();
                localStorage.setItem(LS_KEY, '1');
             }, 2 * 1000);
        }
    });
JS;
$this->registerJs($js);