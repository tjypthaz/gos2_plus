<?php

use app\modules\erm\models\IndikatorKeperawatan;
use app\modules\erm\models\JenisIndikatorKeperawatan;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\search\IndikatorKeperawatan $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Indikator Keperawatans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indikator-keperawatan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Indikator Keperawatan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'JENIS',
            [
                    'attribute' => 'JENIS',
                'value' => function($model){
                    return Yii::$app->db_erm->createCommand("select deskripsi from medicalrecord.jenis_indikator_keperawatan 
                    where ID = :id")
                        ->bindValue(':id',$model->JENIS)
                        ->queryScalar();
                },
                'filter' => ArrayHelper::map(JenisIndikatorKeperawatan::find()->where('STATUS = 1')->all(),'ID','DESKRIPSI')
            ],
            'DESKRIPSI',
            //'STATUS',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, IndikatorKeperawatan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'JENIS' => $model->JENIS, 'ID' => $model->ID]);
                 }
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
        ]
    ]); ?>


</div>
