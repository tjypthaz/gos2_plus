<?php

use app\modules\pembayaran\models\TagihanAmbulan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\search\TagihanAmbulan $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tagihan Ambulans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tagihan-ambulan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tagihan Ambulan', ['list-tagihan'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'idJenisAmbulan0.deskripsi',
            //'idTagihan',
            'tanggal',
            'noRm',
            'namaPasien',
            //'kilometer',
            //'jasaSarana',
            //'jasaPelayanan',
            'tarif',
            [
                    'attribute' => 'status',
                'value' => function ($model){
                    return TagihanAmbulan::getStatus($model->status);
                },
                'filter' => TagihanAmbulan::getStatus()
            ],
            //'status',
            //'publish',
            //'createDate',
            //'createBy',
            //'updateDate',
            //'updateBy',
            [
                'class' => ActionColumn::className(),
                'template' => "{view}&nbsp;{update}&nbsp;{delete}&nbsp;{print}",
                'buttons' => [
                    'print' => function ($url, $model) {
                        return Html::a('Cetak Kwitansi', $url, [
                            'title' => Yii::t('app', 'lead-print'),
                            'class' => 'btn btn-success btn-sm',
                            'target' => '_blank'
                        ]);
                    },
                ],
                'urlCreator' => function ($action, TagihanAmbulan $model, $key, $index, $column) {
                    if ($action === 'print') {
                        return Url::toRoute(['print', 'id' => $model->id]);
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
