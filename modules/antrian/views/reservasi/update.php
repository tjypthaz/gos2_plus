<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\Reservasi $model */

$this->title = 'Update Reservasi: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Reservasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reservasi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
