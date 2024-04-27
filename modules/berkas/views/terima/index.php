<?php

use app\modules\berkas\models\TerimaBerkas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\berkas\models\search\TerimaBerkas $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Terima Berkas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terima-berkas-index">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>-->
        <?php //Html::a('Create Terima Berkas', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            'NOPEN',
            [
                'attribute' => 'noRm',
                'value' => function($model){
                    return TerimaBerkas::getDatapasien($model->NOPEN);
                },
                'format' => 'html'
            ],
            'TGL_TERIMA',
            [
                    'attribute' => 'TERIMA',
                'value' => function($model){
                    return TerimaBerkas::getStatusTerima($model->TERIMA);
                },
                'filter' => TerimaBerkas::getStatusTerima()
            ],
            //'KETERANGAN',
            [
                'attribute' => 'KASUS_KHUSUS',
                'value' => function($model){
                    return TerimaBerkas::getStatusKasusKhusus($model->KASUS_KHUSUS);
                },
                'filter' => TerimaBerkas::getStatusKasusKhusus()
            ],
            [
                'attribute' => 'INFORMED_CONSENT',
                'value' => function($model){
                    return TerimaBerkas::getStatusInformedConsent($model->INFORMED_CONSENT);
                },
                'filter' => TerimaBerkas::getStatusInformedConsent()
            ],
            [
                'attribute' => 'RESUME_MEDIS',
                'value' => function($model){
                    return TerimaBerkas::getStatusBerkasRm($model->RESUME_MEDIS);
                },
                'filter' => TerimaBerkas::getStatusBerkasRm()
            ],
            //'KASUS_KHUSUS',
            //'INFORMED_CONSENT',
            //'RESUME_MEDIS',
            //'TGL_KEMBALI',
            //'RUANGAN_KEMBALI',
            //'OLEH',
            //'STATUS',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TerimaBerkas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>


</div>
