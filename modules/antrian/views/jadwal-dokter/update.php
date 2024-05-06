<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\JadwalDokterHfis $model */

$this->title = 'Update Jadwal Dokter Hfis: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Dokter Hfis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jadwal-dokter-hfis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
