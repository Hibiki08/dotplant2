<?php
$this->title = Yii::t('app', 'Сео тексты');
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

<div class="list-group">

    <div class="row">
        <div class="col-lg-6 list-group-item text-center alert-info">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Управление шаблонами сео-текстов для категорий и товаров') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Создание и редактирование шаблонов сео-текстов для категорий и товаров') . '</p>',
                ['/seotext/seo-text'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>

        <div class="clearfix"></div>

        <div class="col-lg-3 list-group-item">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Выражения для городов') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Создание переменных для городов для подстановки в сео текстах') . '</p>',
                ['/seotext/city-vars'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>
        
        <div class="col-lg-3 list-group-item">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Управление параметрами городов') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Управление параметрами каждого города для подстановки в шаблонах') . '</p>',
                ['/seotext/city-vars-items'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>
        <div class="clearfix"></div>
    

        <div class="col-lg-3 list-group-item">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Выражения для категорий') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Создание переменных для категорий для подстановки в сео текстах') . '</p>',
                ['/seotext/category-vars'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>
        
        <div class="col-lg-3 list-group-item">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Управление параметрами категорий') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Управление параметрами каждой категории для подстановки в шаблонах') . '</p>',
                ['/seotext/category-vars-items'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>

        <div class="clearfix"></div>
    
        <div class="col-lg-3 list-group-item">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Выражения для товаров') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Создание переменных для товаров для подстановки в сео текстах') . '</p>',
                ['/seotext/product-vars'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>

        <div class="col-lg-3 list-group-item">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Управление параметрами товаров') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Управление параметрами каждого товара для подстановки в шаблонах') . '</p>',
                ['/seotext/product-vars-items'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>

        <div class="clearfix"></div>

        <div class="col-lg-6 list-group-item text-center alert-success">
            <?= \yii\helpers\Html::a(
                '<h4 class="list-group-item-heading">' 
                    . Yii::t('app', 'Тексты о городах') 
                    . '</h4><p class="list-group-item-text">' 
                    . Yii::t('app', 'Создание и редактирование уникальных текстов для каждого города') . '</p>',
                ['/seotext/about-city'],
                [
                    'class' => '',
                ]
            ); ?>
        </div>
    </div>
</div>