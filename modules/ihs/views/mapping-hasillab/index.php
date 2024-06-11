<?php

use app\modules\ihs\models\ParameterHasilToLoinc;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\search\ParameterHasilToLoinc $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Parameter Hasil To Loincs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parameter-hasil-to-loinc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Parameter Hasil To Loinc', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'PARAMETER_HASIL',
            'LOINC_TERMINOLOGI',
            'STATUS',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ParameterHasilToLoinc $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'PARAMETER_HASIL' => $model->PARAMETER_HASIL]);
                 }
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>


</div>
