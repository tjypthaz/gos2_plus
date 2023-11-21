<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\lis\models\Registration $model */

$this->title = 'Update Registration: ' . $model->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Registrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_number, 'url' => ['view', 'order_number' => $model->order_number]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="registration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
