<?php

use app\models\Contact;
use yii\web\View;

/**
 * @var View $this
 * @var Contact[] $contacts
 */
?>
<?php foreach ($contacts as $contact) { ?>
    <div class="container p-0 d-flex flex-md-row flex-xs-column flex-column fade">
        <div class="page-contact__wrapper">
            <div class="page-contact__item">
                <h3>Служба поддержки</h3>
                <p>Телефон:
                    <a href="tel:<?= str_replace([' ', '(', ')', '-'], '', $contact->support_phone_number) ?>">
                        <?= $contact->support_phone_number ?>
                    </a>
                </p>
            </div>
            <div class="page-contact__item">
                <h3>Электронная почта</h3>
                <p><a href="mailto:<?= $contact->email ?>"><?= $contact->email ?></a></p>
            </div>
            <div class="page-contact__item">
                <h3>Адрес офиса</h3>
                <p><?= $contact->address ?></p>
            </div>
            <!--<div class="page-contact__item">
                <h3>Социальные сети</h3>
                <div class="page-contact__social">
                    <ul class="d-flex flex-row">
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fab fa-vk"></i></a></li>
                        <li><a href="#"><i class="fab fa-odnoklassniki"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> </a></li>
                    </ul>
                </div>
            </div>-->
            <br>
            <br>
            <br>
        </div>
        <div class="page-contact__map">
            <?php if (!empty($contact->map_latitude) && !empty($contact->map_longitude)) { ?>
                <iframe src="https://yandex.ru/map-widget/v1/?ll=<?= $contact->map_longitude ?>,<?= $contact->map_latitude ?>&pt=<?= $contact->map_longitude ?>,<?= $contact->map_latitude ?>&z=<?= $contact->map_zoom ?>&l=map" width="100%" height="310" frameborder="0"></iframe>
            <?php } ?>
        </div>
    </div>
<?php } ?>

