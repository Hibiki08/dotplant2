<?php
use yii\helpers\Url;

$percent = round(100 * $imported / $total, 1);
$this->title = Yii::t('app', "Импорт товаров {$percent}%");
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

<div class="list-group">
    <h1>Не закрывайте это окно, пока не закончится импорт</h1>
    <p class="">В случае прерывания для продолжения просто обновите страницу (F5).</p>
    
    <div class="row">
        <div class="col-lg-6 list-group-item text-center alert-info">
            <div style="top:0; left: 0; position:absolute; background-color: red; height:100%; width: <?= $percent ?>%; opacity: 30%;">
            </div>
            <div>
                Импортировано товаров: <?= $percent ?>% (<?= $imported ?> из <?= $total ?>)
            </div>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<script>
    window.location.href="<?= Url::to(['save', 
        'categories' => 0, 
        'imported' => $imported, 
    ])?>";
</script>