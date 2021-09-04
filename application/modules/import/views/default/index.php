<?php
$this->title = Yii::t('app', 'Импорт товаров');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

<div class="list-group">

    <div class="row">
        <div class="col-lg-6 list-group-item text-center alert-info">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Закачать новый файл') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Закачиваем новый файл для запуска процесса нового импорта') . '</p>',
                ['/imp/default/download'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>

        <div class="clearfix"></div>

        <div class="col-lg-6 list-group-item text-center alert-info">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Импортировать файл в БД') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Импортируем файл в БД для подготовки к импорту') . '</p>',
                ['/imp/default/import'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>
        
        <div class="clearfix"></div>

        <div class="col-lg-6 list-group-item text-center alert-info">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Сохранить данные в БД') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Растаскиваем по БД полученные данные (по категориям, товарам исвойствам)') . '</p>',
                ['/imp/default/import-form'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>

        <div class="clearfix"></div>

        <div class="col-lg-3 list-group-item alert alert-danger" style="display:none;">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Удалить все категории и товары из бд') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Очистка БД от товаров и категорий') . '</p>',
                ['/imp/default/clear'],
                [
                    'style' => 'color: white;',
                    'data' => [
                        'confirm' => 'Вы точно хотите очистить БД от товаров и категорий. Данное действие невозможно откатить или отменить!!!',
                        'method' => 'POST',
                    ],
                ]
            ); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>