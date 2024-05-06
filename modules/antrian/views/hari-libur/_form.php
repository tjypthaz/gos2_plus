<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\LiburNasional $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="libur-nasional-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TANGGAL_LIBUR')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'KETERANGAN')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
