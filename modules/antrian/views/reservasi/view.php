<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\Reservasi $model */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Reservasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reservasi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'TANGGALKUNJUNGAN',
            'TANGGAL_REF',
            'NORM',
            'NIK',
            'NAMA',
            'TEMPAT_LAHIR',
            'TANGGAL_LAHIR',
            'ALAMAT:ntext',
            'PEKERJAAN',
            'INSTANSI_ASAL',
            'JK',
            'WILAYAH',
            'PROFESI',
            'POLI',
            'POLI_BPJS',
            'REF_POLI_RUJUKAN',
            'DOKTER',
            'CARABAYAR',
            'JENIS_KUNJUNGAN',
            'NO_KARTU_BPJS',
            'CONTACT',
            'TGL_DAFTAR',
            'NO',
            'ANTRIAN_POLI',
            'NOMOR_ANTRIAN',
            'JAM',
            'JAM_PELAYANAN',
            'ESTIMASI_PELAYANAN',
            'POS_ANTRIAN',
            'JENIS',
            'JADWAL_DOKTER',
            'NO_REF_BPJS',
            'JENIS_REF_BPJS',
            'JENIS_REQUEST_BPJS',
            'POLI_EKSEKUTIF_BPJS',
            'REF',
            'SEP',
            'RAWAT_INAP',
            'JENIS_APLIKASI',
            'STATUS',
            'REF_JADWAL',
            'JAM_PRAKTEK',
            'WAKTU_CHECK_IN',
            'LOKET_RESPON',
            'UPDATE_TIME',
            'VAKSIN_KE',
        ],
    ]) ?>

</div>
