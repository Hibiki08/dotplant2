<?php

/**
 * @var app\components\WebView $this
 * @var boolean $isInSidebar
 * @var boolean $hideEmpty
 * @var array $filtersArray
 * @var boolean $displayHeader
 * @var string $header
 * @var string $id
 * @var array $urlParams
 * @var bool $usePjax
 */

use app\modules\shop\models\ConfigConfigurationModel;
use app\modules\shop\widgets\PropertiesSliderRangeWidget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$sidebarClass = $isInSidebar ? 'sidebar-widget' : '';
if ($usePjax) {
    $this->registerJs("$('#{$id}').dotPlantSmartFilters();");
}
$filterMode = Yii::$app->getModule('shop')->multiFilterMode;

$requestParams = Yii::$app->request->get();
?>
<?php if (false === empty($filtersArray)) : ?>
    <div class="menu-aside__wrapper fade <?= $sidebarClass ?>">
        <?php if ($displayHeader === true): ?>
            <div class="menu-aside__header d-lg-block d-sm-none d-none">
                <h2><i class="fas fa-sort-amount-down"></i> <?= $header ?></h2>
            </div>
        <?php endif; ?>
        <div class="filters d-lg-block d-sm-none d-none" id="<?= $id ?>">
            <?=
            Html::beginForm(
                ['@category', 'last_category_id' => $urlParams['last_category_id']],
                'GET',
                [
                    'class' => 'filter-form',
                ]
            )
            ?>
            <?= Html::hiddenInput('page', '0'); ?>
            <?= Html::hiddenInput('sort', $requestParams['sort'] ?? '1'); ?>
            <?= Html::hiddenInput('limit', $requestParams['limit'] ?? '24'); ?>
            <?= Html::hiddenInput('listDisplay', $requestParams['listDisplay'] ?? 'grid'); ?>

            <?php foreach ($filtersArray as $filter): ?>
                <div class="filter-property">
                    <?php if ($filter['isRange']): ?>
                        <?=
                        PropertiesSliderRangeWidget::widget(
                            [
                                'property' => $filter['property'],
                                'categoryId' => $urlParams['last_category_id'],
                                'maxValue' => $filter['max'],
                                'minValue' => $filter['min'],
                                'step' => $filter['step'],
                            ]
                        )
                        ?>
                    <?php else: ?>
                        <div class="filters__desktop-property-name active"><?= Html::encode($filter['name']) ?></div>
                        <div class="filters__desktop-property-data" data-multiple="<?= $filter['multiple'] ?>" style="display: block">
                            <?php foreach ($filter['selections'] as $selection): ?>
                                
                                    <?php
                                    if ($filter['multiple']) {
                                        switch ($filterMode) {
                                            case ConfigConfigurationModel::MULTI_FILTER_MODE_INTERSECTION:

                                                $spanClass = ($selection['active'] !== true && $selection['checked'] !== true) ? 'filter-disabled' : '';
                                                echo '<label class="chk-container  ' . $spanClass . '">' . $selection['label'];
                                                echo Html::checkbox(
                                                    'properties[' . $filter['id'] . '][]',
                                                    $selection['checked'],
                                                    [
                                                        'value' => $selection['id'],
                                                        'class' => 'filter-check filter-check-property-' . $filter['id'],
                                                        'id' => 'filter-check-' . $selection['id'],
                                                        'data-property-id' => $filter['id'],
                                                        'disabled' => $selection['active'] === true || $selection['checked'] === true
                                                            ? null
                                                            : 'disabled',
                                                    ]
                                                );
                                                
                                                echo '<span class="chk-mark filter-link" data-selection-id="' 
                                                    . $selection['id'] . '" data-property-id="' 
                                                    . $filter['id'] . '"></span>';
                                                echo '</label>';

                                                /*
                                                echo $selection['active'] === true || $selection['checked'] === true
                                                    ? Html::a(
                                                        $selection['label'],
                                                        $selection['url'],
                                                        [
                                                            'class' => 'filter-link',
                                                            'data-selection-id' => $selection['id'],
                                                            'data-property-id' => $filter['id'],
                                                            'rel' => !$selection['checked'] ? null : 'nofollow',
                                                        ]
                                                    )
                                                    : Html::tag('span', $selection['label'], ['class' => 'inactive-filter']);
                                                */
                                                break;
                                            case ConfigConfigurationModel::MULTI_FILTER_MODE_UNION:
                                                echo Html::checkbox(
                                                    'properties[' . $filter['id'] . '][]',
                                                    $selection['checked'],
                                                    [
                                                        'value' => $selection['id'],
                                                        'class' => 'filter-check filter-check-property-' . $filter['id'],
                                                        'id' => 'filter-check-' . $selection['id'],
                                                        'data-property-id' => $filter['id'],
                                                    ]
                                                );

                                                echo Html::a(
                                                    $selection['label'],
                                                    $selection['url'],
                                                    [
                                                        'class' => 'filter-link',
                                                        'data-selection-id' => $selection['id'],
                                                        'data-property-id' => $filter['id'],
                                                        'rel' => !$selection['checked'] ? null : 'nofollow',
                                                    ]
                                                );

                                                break;
                                        }
                                    } else {
                                        echo 
                                        '<label class="chk-container' . ($selection['active'] === true || $selection['checked'] === true ? '' : ' inactive-filter') . '">'
                                        . $selection['label']
                                        . Html::checkbox(
                                            'properties[' . $filter['id'] . '][]',
                                            $selection['checked'],
                                            [
                                                'value' => $selection['id'],
                                                'class' => 'filter-check filter-check-property-' . $filter['id'],
                                                'id' => 'filter-check-' . $selection['id'],
                                                'data-property-id' => $filter['id'],
                                                'disabled' => $selection['active'] === true || $selection['checked'] === true
                                                    ? null
                                                    : 'disabled',
                                            ]
                                        )
                                        . Html::tag('span', '', [
                                            'class' => $selection['active'] === true || $selection['checked'] === true ? 'chk-mark filter-link' : 'chk-mark filter-link inactive-filter',
                                            'data-property-id' => $filter['id'],
                                            'data-selection-id' => $selection['id'],
                                            'disabled' => $selection['active'] === true || $selection['checked'] === true
                                                    ? null
                                                    : 'disabled',
                                        ])
                                        . '</label>';
                                        /*
                                        echo $selection['active'] === true || $selection['checked'] === true
                                            ? Html::a(
                                                $selection['label'],
                                                $selection['url'],
                                                [
                                                    'class' => 'filter-link',
                                                    'data-selection-id' => $selection['id'],
                                                    'data-property-id' => $filter['id'],
                                                    'rel' => !$selection['checked'] ? null : 'nofollow',
                                                ]
                                            )
                                            : Html::tag('span', $selection['label'], ['class' => 'inactive-filter']);
                                        */
                                    }

                                    ?>
                                
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <div class="filter-actions">
                <?=
                Html::submitButton(
                    Yii::t('app', 'Применить фильтры'),
                    [
                        'class' => 'filter-button btn btn-primary btn-filter-show',
                    ]
                )
                ?>
            </div>
            <?= Html::endForm() ?>
            <div class="overlay"></div>
        </div>
    </div>
    <?php
    $JS = <<<JS
(function($){
"use strict"
$('.filter-check').change(function(){
    var \$multiple = $(this).parents('ul.property-values').data('multiple');
    if (0 === \$multiple) {
        if (true === $(this).prop('checked')) {
            $(this).parents('ul.property-values').find('input[type=checkbox]').not(this).each(function(){
                $(this).prop('checked', false);
            })
        }
    }
});
})(jQuery)
JS;
    $this->registerJs($JS);
    ?>
<?php endif; ?>