<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\ParameterHasilToLoinc $model */

$this->title = 'Update Parameter Hasil To Loinc: ' . $model->PARAMETER_HASIL;
$this->params['breadcrumbs'][] = ['label' => 'Parameter Hasil To Loincs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PARAMETER_HASIL, 'url' => ['view', 'PARAMETER_HASIL' => $model->PARAMETER_HASIL]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parameter-hasil-to-loinc-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
