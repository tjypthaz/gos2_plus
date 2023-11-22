<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\lis\models\MappingHasil $model */

$this->title = 'Update Mapping Hasil: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Hasils', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mapping-hasil-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
