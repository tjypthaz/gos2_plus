<?php

use app\modules\antrian\models\LiburNasional;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\search\LiburNasional $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Libur Nasionals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libur-nasional-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Libur Nasional', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            'TANGGAL_LIBUR',
            'KETERANGAN',
            'TANGGAL',
            //'OLEH',
            'STATUS',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, LiburNasional $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>


</div>
