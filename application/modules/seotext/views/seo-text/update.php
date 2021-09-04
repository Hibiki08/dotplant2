<?php

use app\backend\widgets\BackendWidget;
use app\components\Helper;
use app\models\Country;
use kartik\helpers\Html;
use yii\helpers\Url;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use yii\web\View;
use yii\web\JsExpression;
use kartik\widgets\SwitchInput;
use app\modules\seotext\models\SeoCityVar;
use app\modules\seotext\models\SeoCategoryVar;
use app\modules\seotext\models\SeoProductVar;
use app\modules\shop\models\Category;
use yii\helpers\ArrayHelper;
//use dosamigos\multiselect\MultiSelect;
use gudezi\fancytree\FancytreeWidget;

/**
 * @var View $this
 * @var SeoCityVar $model
 */



$cityVars = SeoCityVar::find()->all();
$categoryVars = SeoCategoryVar::find()->all();
$categoryVars[] = new SeoCategoryVar(['word' => 'cat_url', 'example' => '/catalog/fallo']);

$productVars = SeoProductVar::find()->all();
$productVars[] = new SeoProductVar(['word' => 'product_name', 'example' => 'Дилдо ХХХ']);
$productVars[] = new SeoProductVar(['word' => 'product_url', 'example' => '/catalog/fallo/dildo-xxx']);

$this->title = $model->isNewRecord ?
    Yii::t('app', 'Create') :
    Yii::t('app', 'Update');

$this->params['breadcrumbs'][] = [
    'url' => ['/seotext'],
    'label' => Yii::t('app', 'Сео тексты'),
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Шаблоны сео-текстов для категорий и товаров'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('submit'); ?>
<div class="form-group no-margin">
    <?= Html::a(
        Icon::show('arrow-circle-left') . Yii::t('app', 'Back'),
        Yii::$app->request->get('returnUrl', ['/seotext/about-city/index']),
        ['class' => 'btn btn-danger']
    ) ?>
    <?php if ($model->isNewRecord) { ?>
        <?= Html::submitButton(
            Icon::show('save') . Yii::t('app', 'Save & Go next'),
            [
                'class' => 'btn btn-success',
                'name' => 'action',
                'value' => 'next',
            ]
        ) ?>
    <?php } ?>
    <?= Html::submitButton(
        Icon::show('save') . Yii::t('app', 'Save & Go back'),
        [
            'class' => 'btn btn-warning',
            'name' => 'action',
            'value' => 'back',
        ]
    ) ?>
    <?= Html::submitButton(
        Icon::show('save') . Yii::t('app', 'Save'),
        [
            'class' => 'btn btn-primary',
            'name' => 'action',
            'value' => 'save',
        ]
    ) ?>
</div>
<?php $this->endBlock('submit'); ?>

<div class="seotexts container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <?php $form = ActiveForm::begin(); ?>

            <?php BackendWidget::begin([
                'icon' => 'tag',
                'title' => Yii::t('app', 'SeoCityVar'),
                'footer' => $this->blocks['submit'],
            ]); ?>

            <?= $form->field($model, 'description')->textInput() ?>

            <div class="row">
                <div class="col-md-1"><strong>Категории:</strong></div> 
                <div class="col-md-11">

                <?= \delikatesnsk\treedropdown\DropdownTreeWidget::widget([
                    'id' => 'organizationsList', //<-- id контейнера выпадающего списка (ВНИМАНИЕ! Обязателен, если на странице несколько DropdownTreeWidget)
                    'form' => $form, // <-- ActiveForm (форма, для генерации скрытого input который будет отправлен в контроллер после submit формы)
                    'model' => $model, // <-- Model  (модель, для генерации скрытого input в который и будут подставляться выбранные значения)
                    'attribute' => 'categoryIds', //<-- Model attribute  (атрибут модели, для генерации скрытого input)
                    'label' => \Yii::t('app', 'Категории'), //Заголовок выпадающего списка
                    'multiSelect' => true, //Если true, то из списка можно будет выбрать более одного значения
                    'searchPanel' => [
                                        'visible' => true, //Если true, то будет отображена панели с полем для поиска по дереву
                                        'label' => 'Выберите категории', //Заголовок для панели
                                        'placeholder' => 'Выберите категории',  //Текст-подсказка внутри поля для поиска
                                        'searchCaseSensivity' => false //Если True, то поиск по дереву будет регистрозависимый
                                    ], 
                    'rootNode' => [
                                    'visible' => false, //Отображать корневой узел или нет
                                    'label' => \Yii::t('app', 'Каталог') //Название корневого узла
                                ],
                    'expand' => false, //Распахнуть выпадающий список сразу после отображения

                    'items' =>  Category::getArrayForTreeInput(1),
                ]);
                ?>
                </div>
            </div>
            
            <br>
            <p></p>

            <?= $form->field($model, 'text')->textArea(['id' => 'js__seo-text-area', 'rows' => 12]) ?>

            

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'inProduct')->widget(SwitchInput::classname(), []) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'inCategory')->widget(SwitchInput::classname(), []) ?>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-6">
                    <?= $form->field($model, 'subdomain_ids')->widget(
                            \kartik\select2\Select2::class,
                            [
                                'data' => $model->subdomainsData,
                                'options' => [
                                    'placeholder' => '',
                                    'multiple' => true,
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                                ],
                            ]
                        ) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'excl_subdomain_ids')->widget(
                            \kartik\select2\Select2::class,
                            [
                                'data' => $model->subdomainsData,
                                'options' => [
                                    'placeholder' => '',
                                    'multiple' => true,
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 0,
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                                ],
                            ]
                        ) ?>
                </div>
                <div class="clearfix"></div>
            </div>

            

            <?php BackendWidget::end(); ?>
            <?php ActiveForm::end() ?>
        </div>
        <div class="col-lg-4">
            <h3 class="inserts">
                Выражения для вставки
            </h3>
            <div class="hint">Поместите курсов в текстовом поле в нужном месте и нажмите кнопку ниже</div>
            <p class="group_name">Города<p>
            <?php foreach($cityVars as $var): ?>
                <code class="js__vars btn btn-primary wrap-text" data-var="{<?= $var->word ?>}">
                    {<?= $var->word ?>} => <?= $var->example ?>
                </code>
            <?php endforeach; ?>

            <p class="group_name">Категории<p>
            <?php foreach($categoryVars as $var): ?>
                <code class="js__vars btn btn-primary wrap-text" data-var="{<?= $var->word ?>}">
                    {<?= $var->word ?>} => <?= $var->example ?>
                </code>
            <?php endforeach; ?>

            <p class="group_name">Товары<p>
            <?php foreach($productVars as $var): ?>
                <code class="js__vars btn btn-primary wrap-text" data-var="{<?= $var->word ?>}">
                    {<?= $var->word ?>} => <?= $var->example ?>
                </code>
            <?php endforeach; ?>
        </div>
    </div>
</div>
