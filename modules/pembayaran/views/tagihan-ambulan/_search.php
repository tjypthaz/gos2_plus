<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\search\TagihanAmbulan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tagihan-ambulan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idJenisAmbulan') ?>

    <?= $form->field($model, 'idTagihan') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'noRm') ?>

    <?php // echo $form->field($model, 'namaPasien') ?>

    <?php // echo $form->field($model, 'kilometer') ?>

    <?php // echo $form->field($model, 'jasaSarana') ?>

    <?php // echo $form->field($model, 'jasaPelayanan') ?>

    <?php // echo $form->field($model, 'tarif') ?>

    <?php // echo $form->field($model, 'status') ?>

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
