<?php
/**
 * @var \yii\web\View $this
 */
use \yii\helpers\Url;
use \yii\helpers\Html;
$this->title = 'Личный кабинет';
?>
<div class="page__title text-xl-left text-sm-center text-center fade"><i class="fas fa-user"></i><h1><?= $this->title ?></h1></div>
    <div class="container p-0 fade">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="user-profile__wrapper">
                    <div class="user-profile__user-info-header">
                        <h2 class="mb-0">Контактные данные</h2>
                        <a href="<?= Url::to('/user/user/profile') ?>"><i class="far fa-edit" title="Изменить контактные данные"></i></a>
                    </div>
                    <div class="user-profile__user-info">
                        <div class="row">
                            <div class="col-4 el">Имя:</div>
                            <div class="col-8 val"><?= $model->first_name?></div>
                        </div>
                        <div class="row">
                            <div class="col-4 el">Фамилия:</div>
                            <div class="col-8 val">><?= $model->last_name?></div>
                        </div>
                        <div class="row">
                            <div class="col-4 el">Телефон:</div>
                            <div class="col-8 val"><?= $model->phone?></div>
                        </div>
                        <div class="row">
                            <div class="col-4 el">Email:</div>
                            <div class="col-8 val"><?= $model->email?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="user-profile__wrapper">
                    <div class="user-profile__user-info-header">
                        <h2 class="mb-0">Адрес доставки</h2>
                        <?php if($adress): ?>
                            <a href="<?= Url::to(['/shop/address/update', 'id' => $adress->id,]) ?>">
                                <i class="far fa-edit" title="Изменить адрес доставки"></i>
                            </a>
                        <?php else: ?>
                            <a href="<?= Url::to(['/shop/address/create', ]) ?>">
                                <i class="fa fa-plus" title="Создать адрес доставки"></i>
                            </a>
                        <?php endif;?>
                    </div>
                    <div class="user-profile__user-info">
                        <div class="row">
                            <div class="col-4 el">Страна:</div>
                            <div class="col-8 val"><?= ($adress ? $adress->country->name : '') ?></div>
                        </div>
                        <div class="row">
                            <div class="col-4 el">Город:</div>
                            <div class="col-8 val"><?= ($adress ? $adress->city->name : '')?></div>
                        </div>
                        <div class="row">
                            <div class="col-4 el">Индекс:</div>
                            <div class="col-8 val"><?= ($adress ? $adress->zip_code : '')?></div>
                        </div>
                        <div class="row">
                            <div class="col-4 el">Адрес:</div>
                            <div class="col-8 val"><?= ($adress ? $adress->address : '')?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>