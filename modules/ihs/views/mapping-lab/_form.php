<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\TindakanToLoinc $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tindakan-to-loinc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $listTindakan = ArrayHelper::map(Yii::$app->db_ihs
        ->createCommand("
        SELECT a.`ID`,concat(a.`ID`,' - ',a.`NAMA`) NAMA
        FROM `master`.`tindakan` a
        WHERE a.`STATUS` = 1 and a.JENIS = 8
        ORDER BY a.`NAMA` ASC 
        ")->queryAll(),'ID','NAMA') ;

    echo $form->field($model, 'TINDAKAN')->widget(Select2::classname(), [
        'data' => $listTindakan,
        'options' => ['placeholder' => 'Ketikan Nama Tindakan Laboratorium'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?php
    $listLoinc = ArrayHelper::map(Yii::$app->db_ihs
        ->createCommand("
        SELECT a.`id`,concat('( ',a.`Kategori_pemeriksaan`,' - ',a.`nama_pemeriksaan`,')','--(',a.code,'-',a.display,' )') NAMA
        FROM `kemkes-ihs`.`loinc_terminologi` a
        ORDER BY a.`Kategori_pemeriksaan` ASC 
        ")->queryAll(),'id','NAMA') ;

    echo $form->field($model, 'LOINC_TERMINOLOGI')->widget(Select2::classname(), [
        'data' => $listLoinc,
        'options' => ['placeholder' => 'Ketikan Loinc Terminologi'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>



    <?php
    $listSpesimen = ArrayHelper::map(Yii::$app->db_ihs
        ->createCommand("
        SELECT a.`id`,CONCAT(a.`code`,' - ',a.`display`) NAMA
        FROM `type_code_reference` a
        WHERE a.`type` = 52 AND a.`status` = 1
        order by a.display asc
        ")->queryAll(),'id','NAMA') ;

    echo $form->field($model, 'SPESIMENT')->widget(Select2::classname(), [
        'data' => $listSpesimen,
        'options' => ['placeholder' => 'Ketikan Spesimen'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?php
    $listKategori = ArrayHelper::map(Yii::$app->db_ihs
        ->createCommand("
        SELECT a.`id`,CONCAT(a.`code`,' - ',a.`display`) NAMA
        FROM `type_code_reference` a
        WHERE a.`type` = 58 AND a.`status` = 1
        order by a.display asc
        ")->queryAll(),'id','NAMA') ;

    echo $form->field($model, 'KATEGORI')->widget(Select2::classname(), [
        'data' => $listKategori,
        'options' => ['placeholder' => 'Ketikan Kategori'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
