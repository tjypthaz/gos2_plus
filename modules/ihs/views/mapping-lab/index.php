<?php

use app\modules\ihs\models\TindakanToLoinc;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\search\TindakanToLoinc $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Laboratorium Mapping Loinc';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tindakan-to-loinc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Buat Mapping Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                    'attribute' => 'namaTindakan',
                'value' => function($model){
                    return Yii::$app->db_ihs
                        ->createCommand("select NAMA from master.tindakan where ID = :id")
                        ->bindValue(':id',$model->TINDAKAN)->queryScalar();
                }
            ],
            [
                'attribute' => 'namaLoinc',
                'value' => function($model){
                    return Yii::$app->db_ihs
                        ->createCommand("
                        select concat(Kategori_pemeriksaan,'-<b>',nama_pemeriksaan,'</b><br>',code,'-',display) 
                        from `kemkes-ihs`.`loinc_terminologi` 
                        where id=:id")
                        ->bindValue(':id',$model->LOINC_TERMINOLOGI)->queryScalar();
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'namaSpesimen',
                'value' => function($model){
                    return Yii::$app->db_ihs
                        ->createCommand("select display from `kemkes-ihs`.`type_code_reference` where type = 52 and id=:id")
                        ->bindValue(':id',$model->SPESIMENT)->queryScalar();
                }
            ],
            [
                'attribute' => 'namaKategori',
                'value' => function($model){
                    return Yii::$app->db_ihs
                        ->createCommand("select display from `kemkes-ihs`.`type_code_reference` where type = 58 and id=:id")
                        ->bindValue(':id',$model->KATEGORI)->queryScalar();
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TindakanToLoinc $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'TINDAKAN' => $model->TINDAKAN]);
                 }
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>


</div>
