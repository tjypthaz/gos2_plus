<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\Pengaturan $model */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Pengaturans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pengaturan-view">

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
            'LIMIT_DAFTAR',
            'DURASI',
            'MULAI',
            'BATAS_JAM_AMBIL',
            'POS_ANTRIAN',
            'STATUS',
            'BATAS_MAX_HARI',
            'BATAS_MAX_HARI_BPJS',
            'MATAS_MAX_HARI_KONTROL',
            'UPDATE_TIME',
        ],
    ]) ?>

</div>
