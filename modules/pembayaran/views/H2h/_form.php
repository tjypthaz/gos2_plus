<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\H2h $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="h2h-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $datapasien = Yii::$app->db_pembayaran->createCommand("
        SELECT a.`NAMA`,a.`ALAMAT`,IF(a.`JENIS_KELAMIN`=1,'L','P') JENIS_KELAMIN,DATE(a.`TANGGAL_LAHIR`) TANGGAL_LAHIR
        ,(DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),a.TANGGAL_LAHIR)), '%Y')+0) AS umur
        FROM `master`.`pasien` a
        WHERE a.`NORM` = ".$model->noRm."
        ")->queryOne();
    ?>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'idTagihan')->textInput(['disabled' => 'disabled']) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'noRm')->textInput(['disabled' => 'disabled']) ?>
        </div>
        <div class="col">
            <label class="control-label">Tgl Lahir</label>
            <label class="form-control" readonly=""><?=$datapasien['TANGGAL_LAHIR']?></label>
        </div>
        <div class="col">
            <label class="control-label">Umur</label>
            <label class="form-control" readonly=""><?=$datapasien['umur']." tahun"?></label>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <label class="control-label">Nama Pasien</label>
            <label class="form-control" readonly=""><?=$datapasien['NAMA']." (".$datapasien['JENIS_KELAMIN'].")"?></label>
        </div>
        <div class="col">
            <label class="control-label">Alamat</label>
            <label class="form-control" readonly=""><?=$datapasien['ALAMAT']?></label>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <?= $form->field($model, 'umum')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'naikKelas')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'ambulan')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'ipj')->textInput(['maxlength' => true]) ?>
        </div>
    </div>









    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
