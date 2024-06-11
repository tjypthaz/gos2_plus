<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\TindakanToLoinc $model */

$this->title = 'Update Laboratorium Mapping Loinc: ' . $model->TINDAKAN;
$this->params['breadcrumbs'][] = ['label' => 'Laboratorium Mapping Loinc', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->TINDAKAN, 'url' => ['view', 'TINDAKAN' => $model->TINDAKAN]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tindakan-to-loinc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
