<?php

use app\modules\pembayaran\models\H2h;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\search\H2h $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'H2hs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="h2h-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create H2h', ['list-tagihan'], ['class' => 'btn btn-success']) ?>
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
                'template' => '{delete}',
                'urlCreator' => function ($action, H2h $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
