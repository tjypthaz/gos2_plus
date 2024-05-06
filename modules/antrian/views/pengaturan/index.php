<?php

use app\modules\antrian\models\Pengaturan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\search\Pengaturan $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pengaturan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengaturan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            //'LIMIT_DAFTAR',
            //'DURASI',
            'MULAI',
            'BATAS_JAM_AMBIL',
            'POS_ANTRIAN',
            //'STATUS',
            //'BATAS_MAX_HARI',
            'BATAS_MAX_HARI_BPJS',
            'MATAS_MAX_HARI_KONTROL',
            //'UPDATE_TIME',
            [
                'class' => ActionColumn::className(),
                'template' => '{update}',
                'urlCreator' => function ($action, Pengaturan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
    ]); ?>


</div>
