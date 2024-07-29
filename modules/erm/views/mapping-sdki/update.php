<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\MappingDiagnosaIndikator $model */

$this->title = 'Update Mapping Diagnosa Indikator: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Diagnosa Indikators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mapping-diagnosa-indikator-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
