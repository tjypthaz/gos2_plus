<?php

use app\modules\erm\models\JenisIndikatorKeperawatan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\search\JenisIndikatorKeperawatan $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jenis Indikator Keperawatans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-indikator-keperawatan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jenis Indikator Keperawatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'DESKRIPSI',
            'STATUS',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, JenisIndikatorKeperawatan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
    ]); ?>


</div>
