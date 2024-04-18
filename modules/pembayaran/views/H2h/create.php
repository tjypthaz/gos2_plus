<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\H2h $model */

$this->title = 'Buat Tagihan H2H';
$this->params['breadcrumbs'][] = ['label' => 'Data H2H', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="h2h-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
