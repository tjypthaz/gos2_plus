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
        <?= Html::a('Create H2h', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'idTagihan',
            'noRm',
            'totalTagihan',
            'bayar',
            'status',
            //'publish',
            //'createBy',
            //'createDate',
            //'updateBy',
            //'updateDate',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, H2h $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
