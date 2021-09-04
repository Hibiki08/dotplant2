<?php
/**
 * @var \app\models\View $this
 * @var string $widget_id
 * @var \app\models\Submission $model
 * @var \kartik\form\ActiveForm $form
 */
?>


<?php
if (!empty($object_property_groups)) {
    foreach ($object_property_groups as $i => $opg) {
        if ($opg->group->is_internal) continue;


        /** @var \app\models\Property[] $properties */
        $properties = app\models\Property::getForGroupId($opg->group->id);

        foreach ($properties as $prop) {
            if ($property_values = $model->getPropertyValuesByPropertyId($prop->id)) {
                echo $prop->handler($form, $model->getAbstractModel(), $property_values, 'frontend_render_view');
            }
        }
    }
} else {
    echo '<!-- Empty properties -->';
}
?>

