<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\JadwalDokterHfis $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jadwal-dokter-hfis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'KD_DOKTER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_DOKTER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_SUB_SPESIALIS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_POLI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HARI')->textInput() ?>

    <?= $form->field($model, 'TANGGAL')->textInput() ?>

    <?= $form->field($model, 'NM_HARI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JAM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JAM_MULAI')->textInput() ?>

    <?= $form->field($model, 'JAM_SELESAI')->textInput() ?>

    <?= $form->field($model, 'KAPASITAS')->textInput() ?>

    <?= $form->field($model, 'KOUTA_JKN')->textInput() ?>

    <?= $form->field($model, 'KOUTA_NON_JKN')->textInput() ?>

    <?= $form->field($model, 'LIBUR')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'INPUT_TIME')->textInput() ?>

    <?= $form->field($model, 'UPDATE_TIME')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
