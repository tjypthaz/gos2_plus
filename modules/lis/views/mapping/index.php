<?php

use app\modules\lis\models\MappingHasil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\modules\lis\models\search\MappingHasil $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mapping';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapping-hasil-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Hapus Mapping Sampah', ['hapus-sampah'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'ID',
            //'VENDOR_LIS',
            'LIS_KODE_TEST',
            //'PREFIX_KODE',
            'HIS_KODE_TEST',
            'PARAMETER_TINDAKAN_LAB',
            [
                'class' => ActionColumn::className(),
                'visibleButtons' => [
                    'view' => \Yii::$app->user->can('view'),
                    'update' => \Yii::$app->user->can('update'),
                ],
                'urlCreator' => function ($action, MappingHasil $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ID' => $model->ID]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
