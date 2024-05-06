<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\LiburNasional $model */

$this->title = 'Create Libur Nasional';
$this->params['breadcrumbs'][] = ['label' => 'Libur Nasionals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libur-nasional-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
