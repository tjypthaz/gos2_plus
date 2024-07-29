<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\IndikatorKeperawatan $model */

$this->title = $model->JENIS;
$this->params['breadcrumbs'][] = ['label' => 'Indikator Keperawatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="indikator-keperawatan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'JENIS' => $model->JENIS, 'ID' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'JENIS' => $model->JENIS, 'ID' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'JENIS',
                'value' => function($model){
                    return Yii::$app->db_erm->createCommand("select deskripsi from medicalrecord.jenis_indikator_keperawatan 
                    where ID = :id")
                        ->bindValue(':id',$model->JENIS)
                        ->queryScalar();
                },
            ],
            'ID',
            'DESKRIPSI',
            'STATUS',
        ],
    ]) ?>

</div>
