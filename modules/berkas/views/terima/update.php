<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\berkas\models\TerimaBerkas $model */

$this->title = 'Update Terima Berkas: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Terima Berkas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="terima-berkas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
