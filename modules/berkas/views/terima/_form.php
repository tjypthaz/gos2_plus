<?php

use app\modules\berkas\models\TerimaBerkas;
use kartik\widgets\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\berkas\models\TerimaBerkas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="terima-berkas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'TGL_TERIMA')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Masukan Tanggal Terima'],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]); ?>

    <?= $form->field($model, 'TERIMA')->radioList(TerimaBerkas::getStatusTerima()) ?>

    <?= $form->field($model, 'KASUS_KHUSUS')->radioList(TerimaBerkas::getStatusKasusKhusus()) ?>

    <?= $form->field($model, 'INFORMED_CONSENT')->radioList(TerimaBerkas::getStatusInformedConsent()) ?>

    <?= $form->field($model, 'RESUME_MEDIS')->radioList(TerimaBerkas::getStatusBerkasRm()) ?>

    <?= $form->field($model, 'KETERANGAN')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
