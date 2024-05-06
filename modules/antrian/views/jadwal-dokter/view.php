<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\JadwalDokterHfis $model */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Dokter Hfis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="jadwal-dokter-hfis-view">

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
            'KD_DOKTER',
            'NM_DOKTER',
            'KD_SUB_SPESIALIS',
            'KD_POLI',
            'HARI',
            'TANGGAL',
            'NM_HARI',
            'JAM',
            'JAM_MULAI',
            'JAM_SELESAI',
            'KAPASITAS',
            'KOUTA_JKN',
            'KOUTA_NON_JKN',
            'LIBUR',
            'STATUS',
            'INPUT_TIME',
            'UPDATE_TIME',
        ],
    ]) ?>

</div>
