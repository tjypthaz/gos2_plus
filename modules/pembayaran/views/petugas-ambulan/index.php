<?php

use app\modules\pembayaran\models\PetugasAmbulan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\search\PetugasAmbulan $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Petugas Ambulans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="petugas-ambulan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Petugas Ambulan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'idTagihanAmbulan',
            'idPegawai',
            'publish',
            'createDate',
            //'createBy',
            //'updateDate',
            //'updateBy',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PetugasAmbulan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
