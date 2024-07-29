<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\IndikatorKeperawatan $model */

$this->title = 'Update Indikator Keperawatan: ' . $model->JENIS;
$this->params['breadcrumbs'][] = ['label' => 'Indikator Keperawatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->JENIS, 'url' => ['view', 'JENIS' => $model->JENIS, 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="indikator-keperawatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
