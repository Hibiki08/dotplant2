<?php
/**
 * Use existent form
 * @var \yii\web\View $this
 * @var \app\modules\shop\models\Customer $model
 * @var boolean $immutable
 * @var string $action
 * @var \yii\bootstrap\ActiveForm $form
 * @var array $additional
 */
?>
    <?php if (empty($additional['hideHeader'])): ?>
        <div class="user-profile__user-order-title"><h2><?= Yii::t('app', 'Buyer information') ?></h2></div>
    <?php endif; ?>

    <?= $form->field($model, 'first_name', ['options' => ['class' => 'user-profile__form-item ']])
        ->textInput(['readonly' => $immutable, 'class' => 'input-text']); ?>

    <?= $form->field($model, 'middle_name', ['options' => ['class' => 'user-profile__form-item ']])
        ->textInput(['readonly' => $immutable, 'class' => 'input-text']); ?>

    <?= $form->field($model, 'last_name', ['options' => ['class' => 'user-profile__form-item ']])
        ->textInput(['readonly' => $immutable, 'class' => 'input-text']); ?>

    <?= $form->field($model, 'email', ['options' => ['class' => 'user-profile__form-item ']])
        ->textInput(['readonly' => $immutable, 'class' => 'input-text']); ?>

    <?= $form->field($model, 'phone', ['options' => ['class' => 'user-profile__form-item ']])
        ->textInput(['readonly' => $immutable, 'class' => 'input-text']); ?>

    <?php
        /** @var \app\properties\AbstractModel $abstractModel */
        $abstractModel = $model->getAbstractModel();
        $abstractModel->setArrayMode(false);
        foreach ($abstractModel->attributes() as $attr) {
            echo $form->field($abstractModel, $attr, ['options' => ['class' => 'user-profile__form-item ']])
                    ->textInput(['readonly' => $immutable, 'class' => 'input-text']);
        }
    ?>
