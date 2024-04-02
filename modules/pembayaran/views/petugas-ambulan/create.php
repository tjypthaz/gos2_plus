<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\PetugasAmbulan $model */

$this->title = 'Create Petugas Ambulan';
$this->params['breadcrumbs'][] = ['label' => 'Petugas Ambulans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="petugas-ambulan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
