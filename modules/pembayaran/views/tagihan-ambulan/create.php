<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\TagihanAmbulan $model */

$this->title = 'Create Tagihan Ambulan';
$this->params['breadcrumbs'][] = ['label' => 'Tagihan Ambulans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tagihan-ambulan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
