<?php

$this->title = Yii::t('app', 'Контакты');

$this->params['breadcrumbs'] = [
    $this->title,
];
?>

<div class="page__title text-xl-left text-sm-center text-center d-lg-block d-sm-none d-none fade"><h1><?= $this->title ?></h1></div>
<?= \app\widgets\contacts\CityContacts::widget(['viewFile' => 'main-contacts']) ?>
