<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\Kronis $model */

$this->title = 'Update Kronis: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kronis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kronis-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
