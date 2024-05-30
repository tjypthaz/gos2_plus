<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\Reservasi $model */

$this->title = 'Create Reservasi';
$this->params['breadcrumbs'][] = ['label' => 'Reservasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservasi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
