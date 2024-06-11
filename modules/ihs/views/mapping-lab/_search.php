<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\search\TindakanToLoinc $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tindakan-to-loinc-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'TINDAKAN') ?>

    <?= $form->field($model, 'LOINC_TERMINOLOGI') ?>

    <?= $form->field($model, 'SPESIMENT') ?>

    <?= $form->field($model, 'KATEGORI') ?>

    <?= $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
