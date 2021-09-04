<?php

use app\models\Subdomain;
use app\widgets\subdomain\forms\ChangeSubdomainForm;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 * @var ChangeSubdomainForm $subdomainForm
 * @var Subdomain|null $subdomain
 * @var boolean $suggest
 * @var string $formUrl
 * @var string $searchUrl
 * @var array $allDomains
 */

$subdomainSelected = [];
if ($subdomain) {
    $subdomainSelected = [$subdomain->id => $subdomain->title];
}
?>
<div class="city-choice">
    <a data-fancybox="" data-src="#chose-subdomain-select" href="#" class="text-white">
        <i class="fas fa-map-marker-alt i-location"></i>
        <?= $subdomain ? $subdomain->title : '' ?>
    </a>

    <?php if ($subdomain && $suggest) { ?>
        <div id="city-choice-popup" class="city-choice-popup">
            <?= Yii::t('app', '"это Ваш город"?') ?>
            <?php // todo вернуть перевод ?>
            <?php // Yii::t('app', 'Is this your city?') ?>
            <div class="d-flex align-items-center justify-content-between">
                <button class="form-button small" data-answer="yes" data-id="<?= $subdomain ? $subdomain->id : '' ?>">
                    <?= Yii::t('yii', 'Yes') ?>
                </button>
                <button class="form-button small" data-fancybox="" data-src="#chose-subdomain-select">
                    <?= Yii::t('yii', 'No') ?>
                </button>
            </div>
        </div>
    <?php } ?>

    <div id="chose-subdomain-select" style="display: none; min-width: 600px">
        <?php $form = ActiveForm::begin([
            'action' => $formUrl,
            'method' => 'POST',
        ]) ?>
        <div class="user-modal__form">
            <div class="row">
                <div class="col-md-6">
                    <div class="user-modal__form-header">
                        <h2><?= Yii::t('app', 'Select city') ?></h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <?= $form
                        ->field($subdomainForm, 'subdomain_id', ['options' => ['class' => 'user-modal__form-item', 'style' => 'width:200px']])
                        ->widget(Select2::class, [
                            'options' => ['placeholder' => ''],
                            'data' => $subdomainSelected,
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 3,
                                'ajax' => [
                                    'url' => $searchUrl,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {query:params.term}; }')
                                ],
                                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                'templateResult' => new JsExpression('function(item) { return item.text; }'),
                                'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                            ],
                        ])
                        ->label(false) ?>
                </div>
            </div>
            <div class="row">
                <?php
                $i = 0;
                echo '<div class="col-md-2">';
                foreach ($allDomains as $subDomains) {
                    echo '<a href="#d" class="domList" data-value="' . $subDomains->id . '">' . $subDomains->title . '</a><br />';
                    $i++;
                    if ($i == 21) {
                        $i=0;
                        echo '</div><div class="col-md-2">';
                    }
                }
                echo '</div>';
                ?>
            </div>
            <div class="d-flex align-items-end justify-content-end">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'form-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
<?php

$js = <<<JS
    $(document).ready(function(){
        $('#city-choice-popup').on('click', 'button', function(){
            $(this).parents('#city-choice-popup').fadeOut();
            
            if ($(this).data('answer') === 'yes' && Number($(this).data('id')) > 0) {
                $('#chose-subdomain-select').find('select[name*=subdomain_id]').val(Number($(this).data('id')));
                $('#chose-subdomain-select form').submit();
            }
        });
        
        $('a.domList').on('click', function(){
            $('#changesubdomainform-subdomain_id option:selected').text($(this).text()).val($(this).data('value'));
            $('#select2-changesubdomainform-subdomain_id-container')
                .attr('title', $(this).text())
                .html('<span class="select2-selection__clear">×</span>'+$(this).text());
        });
    });
JS;

$this->registerJs($js);
