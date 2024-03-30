<?php

use app\modules\jaspel\models\JaspelFinal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\search\JaspelFinal $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jaspel Finals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jaspel-final-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Jaspel Final', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'idJaspel',
            'idRuangan',
            'ruangan',
            'tindakan',
            //'idDokterO',
            //'idDokterL',
            //'idPara',
            //'namaDokterO',
            //'namaDokterL',
            //'jenisPara',
            //'jpDokterO',
            //'jpDokterL',
            //'jpPara',
            //'jpStruktural',
            //'jpBlud',
            //'jpPegawai',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, JaspelFinal $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
