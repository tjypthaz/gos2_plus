<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\search\MappingDiagnosaIndikator $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mapping-diagnosa-indikator-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'JENIS') ?>

    <?= $form->field($model, 'INDIKATOR') ?>

    <?= $form->field($model, 'DIAGNOSA') ?>

    <?= $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
