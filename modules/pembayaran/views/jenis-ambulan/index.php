<?php

use app\modules\pembayaran\models\JenisAmbulan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\search\JenisAmbulan $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jenis Ambulans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-ambulan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jenis Ambulan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'deskripsi',
            'jsProp',
            'jpProp',
            'hargaPerKM',
            [
                    'attribute' => 'publish',
                'value' => function($model){
                    return JenisAmbulan::getPublish($model->publish);
                }
            ],
            //'publish',
            //'createDate',
            //'createBy',
            //'updateDate',
            //'updateBy',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, JenisAmbulan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
