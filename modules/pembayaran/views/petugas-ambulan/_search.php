<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\search\PetugasAmbulan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="petugas-ambulan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idTagihanAmbulan') ?>

    <?= $form->field($model, 'idPegawai') ?>

    <?= $form->field($model, 'publish') ?>

    <?= $form->field($model, 'createDate') ?>

    <?php // echo $form->field($model, 'createBy') ?>

    <?php // echo $form->field($model, 'updateDate') ?>

    <?php // echo $form->field($model, 'updateBy') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
