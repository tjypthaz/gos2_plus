<?php

use app\modules\pembayaran\models\H2h;
use kartik\icons\Icon;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\search\H2h $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data H2H';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="h2h-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Buat Tagihan H2H', ['list-tagihan'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'idTagihan',
            //'noRm',
            [
                    'attribute' => 'noRm',
                'value' => function($model){
                    $namapasien = Yii::$app->db_pembayaran->createCommand("
                    SELECT a.`NAMA` FROM `master`.`pasien` a WHERE a.`NORM` = ".$model->noRm."
                    ")->queryScalar();
                    return $model->noRm."<br>".$namapasien;
                },
                'format' => 'raw'
            ],
            'totalTagihan',
            //'bayar',
            [
                'attribute' => 'status',
                'value' => function($model){
                    return H2h::getStatus($model->status);
                },
                'filter' => H2h::getStatus()
            ],
            //'status',
            //'publish',
            //'createBy',
            //'createDate',
            //'updateBy',
            //'updateDate',
            [
                'class' => ActionColumn::className(),
                'template' => '{delete}&nbsp;{print}',
                'buttons' => [
                    'print' => function ($url, $model) {
                        return Html::a(Icon::show('print'), $url, [
                            'title' => 'Cetak Tagihan Untuk H2H',
                            //'class' => 'btn btn-success btn-sm',
                            'target' => '_blank'
                        ]);
                    },
                ],
                'urlCreator' => function ($action, H2h $model, $key, $index, $column) {
                    if ($action === 'print') {
                        return Url::toRoute(['print', 'id' => $model->id]);
                    }
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
