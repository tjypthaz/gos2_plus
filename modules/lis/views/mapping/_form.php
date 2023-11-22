<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\lis\models\MappingHasil $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mapping-hasil-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'VENDOR_LIS')->textInput() ?>

    <?= $form->field($model, 'LIS_KODE_TEST')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PREFIX_KODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HIS_KODE_TEST')->textInput() ?>

    <?= $form->field($model, 'PARAMETER_TINDAKAN_LAB')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
