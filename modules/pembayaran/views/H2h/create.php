<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\H2h $model */

$this->title = 'Create H2h';
$this->params['breadcrumbs'][] = ['label' => 'H2hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="h2h-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
