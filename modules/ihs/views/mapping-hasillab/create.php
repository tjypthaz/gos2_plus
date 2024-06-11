<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\ParameterHasilToLoinc $model */

$this->title = 'Create Parameter Hasil To Loinc';
$this->params['breadcrumbs'][] = ['label' => 'Parameter Hasil To Loincs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parameter-hasil-to-loinc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
