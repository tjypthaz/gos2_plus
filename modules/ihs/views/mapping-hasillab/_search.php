<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\search\ParameterHasilToLoinc $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="parameter-hasil-to-loinc-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'PARAMETER_HASIL') ?>

    <?= $form->field($model, 'LOINC_TERMINOLOGI') ?>

    <?= $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
