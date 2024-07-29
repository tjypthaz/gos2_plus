<?php

use app\modules\erm\models\IndikatorKeperawatan;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\MappingIntervensiIndikator $model */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Intervensi Indikators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mapping-intervensi-indikator-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID], [
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
            'ID',
            [
                'attribute' => 'JENIS',
                'value' => function($model){
                    return Yii::$app->db_erm->createCommand("select deskripsi from medicalrecord.jenis_indikator_keperawatan 
                    where ID = :id")
                        ->bindValue(':id',$model->JENIS)
                        ->queryScalar();
                },
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
                },
            ],
            [
                'attribute' => 'INTERVENSI',
                'value' => function($model){
                    return Yii::$app->db_erm->createCommand("select deskripsi from medicalrecord.indikator_keperawatan 
                    where ID = :id and JENIS = :jenis")
                        ->bindValues([
                            ':id' => $model->INTERVENSI,
                            ':jenis' => 5,
                        ])
                        ->queryScalar();
                },
            ],
            'STATUS',
        ],
    ]) ?>

</div>
