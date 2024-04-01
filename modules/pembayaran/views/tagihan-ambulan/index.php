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
        <?= Html::a('Create Tagihan Ambulan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'idJenisAmbulan',
            'idTagihan',
            'tanggal',
            'noRm',
            //'namaPasien',
            //'kilometer',
            //'jasaSarana',
            //'jasaPelayanan',
            //'tarif',
            //'status',
            //'publish',
            //'createDate',
            //'createBy',
            //'updateDate',
            //'updateBy',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TagihanAmbulan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
