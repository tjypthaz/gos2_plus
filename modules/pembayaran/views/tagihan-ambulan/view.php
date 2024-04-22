<?php

use app\modules\pembayaran\models\PetugasAmbulan;
use app\modules\pembayaran\models\TagihanAmbulan;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\TagihanAmbulan $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Tagihan Ambulan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tagihan-ambulan-view">

    <p>
        <?= Html::a('Tambah Petugas', ['petugas-ambulan/create', 'idTagihanAmbulan' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Lunasi Tagihan', ['lunas', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Pastikan Pasien Sudah Membayar !!?',
                'method' => 'post',
            ],
        ]) ?>
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
            //'id',
            'idJenisAmbulan0.deskripsi',
            'idTagihan',
            'tanggal',
            'noRm',
            'namaPasien',
            'kilometer',
            //'jasaSarana',
            //'jasaPelayanan',
            'tarif',
            [
                'attribute' => 'status',
                'value' => function ($model){
                    return TagihanAmbulan::getStatus($model->status);
                }
            ],
            [
                'label' => 'Petugas',
                'value' => function ($model){
                    $namaPegawai = [];
                    if(count($model->petugasAmbulans) > 0){
                        foreach ($model->petugasAmbulans as $item){
                            $namaPegawai[] = PetugasAmbulan::getNamaPegawai($item->idPegawai);
                        }
                    }
                    if(count($namaPegawai) < 1){
                        return Html::a('Tambah Petugas', ['petugas-ambulan/create', 'idTagihanAmbulan' => $model->id], ['class' => 'btn btn-success']);
                    }
                    return \yii\bootstrap4\Html::ul($namaPegawai);
                },
                'format' => 'html'
            ],
            [
                'attribute' => 'publish',
                'value' => function ($model){
                    return TagihanAmbulan::getPublish($model->publish);
                }
            ],
            //'status',
            //'publish',
            'createDate',
            'createBy',
            'updateDate',
            'updateBy',
        ],
    ]) ?>

</div>
