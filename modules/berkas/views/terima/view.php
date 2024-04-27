<?php

use app\modules\berkas\models\TerimaBerkas;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\berkas\models\TerimaBerkas $model */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Terima Berkas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="terima-berkas-view">

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
            'NOPEN',
            [
                'label' => 'NoRm',
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
                }
            ],
            [
                'attribute' => 'KASUS_KHUSUS',
                'value' => function($model){
                    return TerimaBerkas::getStatusKasusKhusus($model->KASUS_KHUSUS);
                }
            ],
            [
                'attribute' => 'INFORMED_CONSENT',
                'value' => function($model){
                    return TerimaBerkas::getStatusInformedConsent($model->INFORMED_CONSENT);
                }
            ],
            [
                'attribute' => 'RESUME_MEDIS',
                'value' => function($model){
                    return TerimaBerkas::getStatusBerkasRm($model->RESUME_MEDIS);
                }
            ],
            'KETERANGAN',
            //'TGL_KEMBALI',
            //'RUANGAN_KEMBALI',
            'OLEH',
            'STATUS',
        ],
    ]) ?>

</div>
