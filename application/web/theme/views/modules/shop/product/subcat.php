<?php
use yii\helpers\Url;

$img = (file_exists(Yii::getAlias("@app/web/files/category/{$category->id}.jpg"))) ? "/files/category/{$category->id}.jpg" : 'https://placehold.it/450x300';
?>

<div class="col-xl-4 col-md-6 col-12">
    <a href="<?= Url::to('/' . $category->getUrlPath()) ?>">
    <div class="slider-item category__item mt-0">
        <figure style="background-image: url('<?= $img ?>');"></figure>
        <div class="category__item-info">
            <div class="category__item-title"><h2><?= $category->name ?></h2>
            </div>
            <p class="category__item-description visible opacity-5 mt-0"><?= $category->title ?></p>
        </div>
    </div>
    </a>
</div>
