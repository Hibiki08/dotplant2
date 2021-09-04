<?php
/**
 * Use existent form
 * @var \yii\web\View $this
 * @var \app\modules\shop\models\Contragent $model
 * @var boolean $immutable
 * @var string $action
 * @var \yii\bootstrap\ActiveForm $form
 */
?>

    <?php if (empty($additional['hideHeader'])): ?>
        <div class="user-profile__user-order-title"><h2><?= Yii::t('app', 'Payer information') ?></h2></div>
    <?php endif; ?>
    <?= $form->field($model, 'type', ['options' => ['class' => 'user-profile__form-item ']])
        ->dropDownList(
            ['Individual' => Yii::t('app', 'Individual'), 'Self-employed' => Yii::t('app', 'Self-employed'), 'Legal entity' => Yii::t('app', 'Legal entity')],
            ['readonly' => $immutable, 'class' => 'input-text', ]
        ); ?>
    <?php
        /** @var \app\properties\AbstractModel $abstractModel */
        $abstractModel = $model->getAbstractModel();
        $abstractModel->setArrayMode(false);
        foreach ($abstractModel->attributes() as $attr) {
            echo $form->field($abstractModel, $attr, ['options' => ['class' => 'user-profile__form-item ']])
                    ->textInput(['readonly' => $immutable, 'class' => 'input-text']);
        }
    ?>
