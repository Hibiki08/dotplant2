<?php

use app\models\Contact;
use yii\web\View;

/**
 * @var View $this
 * @var Contact[] $contacts
 */

$contact = array_shift($contacts)
?>
<?php if ($contact) { ?>
    <i class="fas fa-phone i-phone"></i><strong><?= $contact->phone_number ?></strong>
<?php } ?>
