<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\search\JenisAmbulan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jenis-ambulan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'deskripsi') ?>

    <?= $form->field($model, 'jsProp') ?>

    <?= $form->field($model, 'jpProp') ?>

    <?= $form->field($model, 'hargaPerKM') ?>

    <?php // echo $form->field($model, 'publish') ?>

    <?php // echo $form->field($model, 'createDate') ?>

    <?php // echo $form->field($model, 'createBy') ?>

    <?php // echo $form->field($model, 'updateDate') ?>

    <?php // echo $form->field($model, 'updateBy') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
