<?php

use app\modules\erm\models\DiagnosaKeperawatan;
use app\modules\erm\models\IndikatorKeperawatan;
use app\modules\erm\models\JenisIndikatorKeperawatan;
use app\modules\erm\models\MappingDiagnosaIndikator;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\search\MappingDiagnosaIndikator $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mapping Diagnosa Indikators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapping-diagnosa-indikator-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mapping Diagnosa Indikator', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            [
                'attribute' => 'INDIKATOR',
                'value' => function($model){
                    return Yii::$app->db_erm->createCommand("select deskripsi from medicalrecord.indikator_keperawatan 
                    where ID = :id and JENIS = :jenis")
                        ->bindValues([
                            ':id' => $model->INDIKATOR,
                            ':jenis' => $model->JENIS,
                        ])
                        ->queryScalar();
                }
            ],
            [
                'attribute' => 'DIAGNOSA',
                'value' => function($model){
                    return Yii::$app->db_erm->createCommand("select concat(kode,' - ',deskripsi) from medicalrecord.diagnosa_keperawatan 
                    where ID = :id")
                        ->bindValue(':id',$model->DIAGNOSA)
                        ->queryScalar();
                },
                'filter' => DiagnosaKeperawatan::getListDiagnosa()
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MappingDiagnosaIndikator $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
        ]
    ]); ?>


</div>
