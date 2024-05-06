<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\JadwalDokterHfis $model */

$this->title = 'Create Jadwal Dokter Hfis';
$this->params['breadcrumbs'][] = ['label' => 'Jadwal Dokter Hfis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jadwal-dokter-hfis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
