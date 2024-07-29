<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\DiagnosaKeperawatan $model */

$this->title = 'Update Diagnosa Keperawatan: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Diagnosa Keperawatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="diagnosa-keperawatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
