<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\MappingIntervensiIndikator $model */

$this->title = 'Update Mapping Intervensi Indikator: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Intervensi Indikators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mapping-intervensi-indikator-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
