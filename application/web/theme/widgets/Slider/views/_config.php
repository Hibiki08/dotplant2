<?php
/** @var null|\yii\base\Model $configurationModel */
/** @var \app\extensions\DefaultTheme\models\ThemeWidgets $widget */
/** @var boolean $isAjax */
/** @var \yii\web\View $this */
/** @var \app\extensions\DefaultTheme\models\ThemeActiveWidgets $model */
/** @var \kartik\form\ActiveForm $form */

?>
<?= $form->field(
    $configurationModel,
    'sliderId'
) ?>
<?= $form->field(
    $configurationModel,
    'inContainer'
)->checkbox() ?>