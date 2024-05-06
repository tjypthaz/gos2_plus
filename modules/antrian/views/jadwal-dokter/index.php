<?php

use app\modules\antrian\models\JadwalDokterHfis;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\search\JadwalDokterHfis $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jadwal Dokter Hfis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-dokter-hfis-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jadwal Dokter Hfis', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'KD_DOKTER',
            'NM_DOKTER',
            'KD_SUB_SPESIALIS',
            'KD_POLI',
            //'HARI',
            //'TANGGAL',
            //'NM_HARI',
            //'JAM',
            //'JAM_MULAI',
            //'JAM_SELESAI',
            //'KAPASITAS',
            //'KOUTA_JKN',
            //'KOUTA_NON_JKN',
            //'LIBUR',
            //'STATUS',
            //'INPUT_TIME',
            //'UPDATE_TIME',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, JadwalDokterHfis $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
    ]); ?>


</div>
