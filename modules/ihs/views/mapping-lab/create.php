<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\TindakanToLoinc $model */

$this->title = 'Laboratorium Mapping Loinc';
$this->params['breadcrumbs'][] = ['label' => 'Laboratorium Mapping Loinc', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tindakan-to-loinc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
