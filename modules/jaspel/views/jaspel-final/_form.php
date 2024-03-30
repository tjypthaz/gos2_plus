<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\JaspelFinal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jaspel-final-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $listDokter = Yii::$app->db_jaspel
        ->createCommand("SELECT a.`ID`,b.`NAMA`
            FROM master.`dokter` a
            LEFT JOIN master.`pegawai` b ON b.`NIP` = a.`NIP`
            WHERE a.`STATUS` = 1 ORDER BY b.`NAMA` ASC")
        ->queryAll();
    $listDokter = ArrayHelper::map($listDokter,'ID','NAMA');

    $listJenisPara = Yii::$app->db_jaspel
        ->createCommand("SELECT a.`ID`,a.`DESKRIPSI`
            FROM master.`referensi` a
            WHERE a.`JENIS` = 32 AND a.`STATUS` = 1 and a.id not in (1,2)")
        ->queryAll();
    $listJenisPara = ArrayHelper::map($listJenisPara,'ID','DESKRIPSI');
    ?>

    <?= $form->field($model, 'idDokterO')->dropDownList($listDokter,[
            'prompt' => 'Pilih Dokter Operator'
    ]) ?>

    <?= $form->field($model, 'idDokterL')->dropDownList($listDokter,[
        'prompt' => 'Pilih Dokter Operator'
    ]) ?>

    <?= $form->field($model, 'idPara')->dropDownList($listJenisPara,[
        'prompt' => 'Pilih Jenis Paramedis'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
