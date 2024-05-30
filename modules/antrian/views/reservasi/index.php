<?php

use app\modules\antrian\models\Reservasi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\search\Reservasi $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'UBAH Status Reservasi Ke 0';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservasi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Pastikan sudah melakukan batal antrian di SIMGOS2</h3>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'TANGGALKUNJUNGAN',
            //'TANGGAL_REF',
            'NORM',
            //'NIK',
            'NAMA',
            //'TEMPAT_LAHIR',
            //'TANGGAL_LAHIR',
            //'ALAMAT:ntext',
            //'PEKERJAAN',
            //'INSTANSI_ASAL',
            //'JK',
            //'WILAYAH',
            //'PROFESI',
            //'POLI',
            'POLI_BPJS',
            //'REF_POLI_RUJUKAN',
            //'DOKTER',
            //'CARABAYAR',
            //'JENIS_KUNJUNGAN',
            'NO_KARTU_BPJS',
            //'CONTACT',
            //'TGL_DAFTAR',
            //'NO',
            //'ANTRIAN_POLI',
            //'NOMOR_ANTRIAN',
            //'JAM',
            //'JAM_PELAYANAN',
            //'ESTIMASI_PELAYANAN',
            //'POS_ANTRIAN',
            //'JENIS',
            //'JADWAL_DOKTER',
            //'NO_REF_BPJS',
            //'JENIS_REF_BPJS',
            //'JENIS_REQUEST_BPJS',
            //'POLI_EKSEKUTIF_BPJS',
            //'REF',
            //'SEP',
            //'RAWAT_INAP',
            'JENIS_APLIKASI',
            'STATUS',
            //'REF_JADWAL',
            //'JAM_PRAKTEK',
            //'WAKTU_CHECK_IN',
            //'LOKET_RESPON',
            //'UPDATE_TIME',
            //'VAKSIN_KE',
            [
                'class' => ActionColumn::className(),
                'template' => '{delete}',
                'urlCreator' => function ($action, Reservasi $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>


</div>
