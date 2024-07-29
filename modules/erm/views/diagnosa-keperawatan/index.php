<?php

use app\modules\erm\models\DiagnosaKeperawatan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\search\DiagnosaKeperawatan $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Diagnosa Keperawatans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diagnosa-keperawatan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Diagnosa Keperawatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'KODE',
            'DESKRIPSI',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, DiagnosaKeperawatan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
        ]
    ]); ?>


</div>
