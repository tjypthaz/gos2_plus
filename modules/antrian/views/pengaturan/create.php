<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\Pengaturan $model */

$this->title = 'Create Pengaturan';
$this->params['breadcrumbs'][] = ['label' => 'Pengaturans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengaturan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
