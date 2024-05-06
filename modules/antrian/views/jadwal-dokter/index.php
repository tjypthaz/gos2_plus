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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NM_DOKTER',
            'NM_HARI',
            //'JAM_MULAI',
            //'JAM_SELESAI',
            'KAPASITAS',
            'KOUTA_JKN',
            'KOUTA_NON_JKN',
            //'LIBUR',
            'STATUS',
            //'INPUT_TIME',
            //'UPDATE_TIME',
            [
                'class' => ActionColumn::className(),
                'template' => '{update}',
                'urlCreator' => function ($action, JadwalDokterHfis $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>


</div>
