<?php

use app\modules\lis\models\Registration;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\lis\models\search\Registration $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Bridging';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registration-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'patient_id',
            [
                'attribute' => 'patient_name',
                'value' => function($model, $key, $index, $column){
                    return $model->patient->patient_name;
                },
            ],
            //'patient.patient_name',
            //'visit_number',
            'order_number',
            'order_datetime',
            //'diagnose_id',
            //'diagnose_name',
            //'service_unit_id',
            //'service_unit_name',
            //'guarantor_id',
            //'guarantor_name',
            //'agreement_id',
            //'agreement_name:ntext',
            //'doctor_id',
            //'doctor_name',
            //'class_id',
            //'class_name',
            //'ward_id',
            'ward_name',
            //'room_id',
            //'room_name',
            //'bed_id',
            //'bed_name',
            //'reg_user_id',
            //'reg_user_name',
            'lis_reg_no',
            //'retrieved_dt',
            //'retrieved_flag',
            [
                'class' => ActionColumn::className(),
                'visibleButtons' => [
                    'delete' => \Yii::$app->user->can('delete'),
                    'update' => \Yii::$app->user->can('update'),
                ],
                'urlCreator' => function ($action, Registration $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'order_number' => $model->order_number]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
