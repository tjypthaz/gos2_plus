<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\search\JadwalDokterHfis $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jadwal-dokter-hfis-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'KD_DOKTER') ?>

    <?= $form->field($model, 'NM_DOKTER') ?>

    <?= $form->field($model, 'KD_SUB_SPESIALIS') ?>

    <?= $form->field($model, 'KD_POLI') ?>

    <?php // echo $form->field($model, 'HARI') ?>

    <?php // echo $form->field($model, 'TANGGAL') ?>

    <?php // echo $form->field($model, 'NM_HARI') ?>

    <?php // echo $form->field($model, 'JAM') ?>

    <?php // echo $form->field($model, 'JAM_MULAI') ?>

    <?php // echo $form->field($model, 'JAM_SELESAI') ?>

    <?php // echo $form->field($model, 'KAPASITAS') ?>

    <?php // echo $form->field($model, 'KOUTA_JKN') ?>

    <?php // echo $form->field($model, 'KOUTA_NON_JKN') ?>

    <?php // echo $form->field($model, 'LIBUR') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'INPUT_TIME') ?>

    <?php // echo $form->field($model, 'UPDATE_TIME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
