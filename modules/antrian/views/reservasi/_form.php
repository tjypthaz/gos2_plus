<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\Reservasi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reservasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TANGGALKUNJUNGAN')->textInput() ?>

    <?= $form->field($model, 'TANGGAL_REF')->textInput() ?>

    <?= $form->field($model, 'NORM')->textInput() ?>

    <?= $form->field($model, 'NIK')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEMPAT_LAHIR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TANGGAL_LAHIR')->textInput() ?>

    <?= $form->field($model, 'ALAMAT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'PEKERJAAN')->textInput() ?>

    <?= $form->field($model, 'INSTANSI_ASAL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JK')->dropDownList([ 'L' => 'L', 'P' => 'P', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'WILAYAH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PROFESI')->textInput() ?>

    <?= $form->field($model, 'POLI')->textInput() ?>

    <?= $form->field($model, 'POLI_BPJS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'REF_POLI_RUJUKAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DOKTER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CARABAYAR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JENIS_KUNJUNGAN')->textInput() ?>

    <?= $form->field($model, 'NO_KARTU_BPJS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CONTACT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TGL_DAFTAR')->textInput() ?>

    <?= $form->field($model, 'NO')->textInput() ?>

    <?= $form->field($model, 'ANTRIAN_POLI')->textInput() ?>

    <?= $form->field($model, 'NOMOR_ANTRIAN')->textInput() ?>

    <?= $form->field($model, 'JAM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JAM_PELAYANAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ESTIMASI_PELAYANAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'POS_ANTRIAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JENIS')->textInput() ?>

    <?= $form->field($model, 'JADWAL_DOKTER')->textInput() ?>

    <?= $form->field($model, 'NO_REF_BPJS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JENIS_REF_BPJS')->textInput() ?>

    <?= $form->field($model, 'JENIS_REQUEST_BPJS')->textInput() ?>

    <?= $form->field($model, 'POLI_EKSEKUTIF_BPJS')->textInput() ?>

    <?= $form->field($model, 'REF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SEP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RAWAT_INAP')->textInput() ?>

    <?= $form->field($model, 'JENIS_APLIKASI')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'REF_JADWAL')->textInput() ?>

    <?= $form->field($model, 'JAM_PRAKTEK')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'WAKTU_CHECK_IN')->textInput() ?>

    <?= $form->field($model, 'LOKET_RESPON')->textInput() ?>

    <?= $form->field($model, 'UPDATE_TIME')->textInput() ?>

    <?= $form->field($model, 'VAKSIN_KE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
