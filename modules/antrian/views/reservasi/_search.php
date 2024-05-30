<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\search\Reservasi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reservasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'TANGGALKUNJUNGAN') ?>

    <?= $form->field($model, 'TANGGAL_REF') ?>

    <?= $form->field($model, 'NORM') ?>

    <?= $form->field($model, 'NIK') ?>

    <?php // echo $form->field($model, 'NAMA') ?>

    <?php // echo $form->field($model, 'TEMPAT_LAHIR') ?>

    <?php // echo $form->field($model, 'TANGGAL_LAHIR') ?>

    <?php // echo $form->field($model, 'ALAMAT') ?>

    <?php // echo $form->field($model, 'PEKERJAAN') ?>

    <?php // echo $form->field($model, 'INSTANSI_ASAL') ?>

    <?php // echo $form->field($model, 'JK') ?>

    <?php // echo $form->field($model, 'WILAYAH') ?>

    <?php // echo $form->field($model, 'PROFESI') ?>

    <?php // echo $form->field($model, 'POLI') ?>

    <?php // echo $form->field($model, 'POLI_BPJS') ?>

    <?php // echo $form->field($model, 'REF_POLI_RUJUKAN') ?>

    <?php // echo $form->field($model, 'DOKTER') ?>

    <?php // echo $form->field($model, 'CARABAYAR') ?>

    <?php // echo $form->field($model, 'JENIS_KUNJUNGAN') ?>

    <?php // echo $form->field($model, 'NO_KARTU_BPJS') ?>

    <?php // echo $form->field($model, 'CONTACT') ?>

    <?php // echo $form->field($model, 'TGL_DAFTAR') ?>

    <?php // echo $form->field($model, 'NO') ?>

    <?php // echo $form->field($model, 'ANTRIAN_POLI') ?>

    <?php // echo $form->field($model, 'NOMOR_ANTRIAN') ?>

    <?php // echo $form->field($model, 'JAM') ?>

    <?php // echo $form->field($model, 'JAM_PELAYANAN') ?>

    <?php // echo $form->field($model, 'ESTIMASI_PELAYANAN') ?>

    <?php // echo $form->field($model, 'POS_ANTRIAN') ?>

    <?php // echo $form->field($model, 'JENIS') ?>

    <?php // echo $form->field($model, 'JADWAL_DOKTER') ?>

    <?php // echo $form->field($model, 'NO_REF_BPJS') ?>

    <?php // echo $form->field($model, 'JENIS_REF_BPJS') ?>

    <?php // echo $form->field($model, 'JENIS_REQUEST_BPJS') ?>

    <?php // echo $form->field($model, 'POLI_EKSEKUTIF_BPJS') ?>

    <?php // echo $form->field($model, 'REF') ?>

    <?php // echo $form->field($model, 'SEP') ?>

    <?php // echo $form->field($model, 'RAWAT_INAP') ?>

    <?php // echo $form->field($model, 'JENIS_APLIKASI') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'REF_JADWAL') ?>

    <?php // echo $form->field($model, 'JAM_PRAKTEK') ?>

    <?php // echo $form->field($model, 'WAKTU_CHECK_IN') ?>

    <?php // echo $form->field($model, 'LOKET_RESPON') ?>

    <?php // echo $form->field($model, 'UPDATE_TIME') ?>

    <?php // echo $form->field($model, 'VAKSIN_KE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
