<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\JenisAmbulan $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jenis Ambulans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="jenis-ambulan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'deskripsi',
            'jsProp',
            'jpProp',
            'hargaPerKM',
            'publish',
            'createDate',
            'createBy',
            'updateDate',
            'updateBy',
        ],
    ]) ?>

</div>
