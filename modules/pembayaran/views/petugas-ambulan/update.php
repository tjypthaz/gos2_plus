<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\PetugasAmbulan $model */

$this->title = 'Update Petugas Ambulan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Petugas Ambulans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="petugas-ambulan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
