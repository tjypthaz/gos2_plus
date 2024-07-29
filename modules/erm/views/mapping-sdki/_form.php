<?php

use app\modules\erm\models\DiagnosaKeperawatan;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\MappingDiagnosaIndikator $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mapping-diagnosa-indikator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $listIndikator = Yii::$app->db_erm->createCommand("
    SELECT CONCAT(a.`JENIS`,'-',a.`ID`) id,CONCAT(b.`DESKRIPSI`,' - ',a.`DESKRIPSI`) indikator 
    FROM `medicalrecord`.`indikator_keperawatan` a
    LEFT JOIN `medicalrecord`.`jenis_indikator_keperawatan` b ON b.`ID` = a.`JENIS`
    WHERE a.`STATUS` = 1
    ORDER BY a.`JENIS` 
    ")
        ->queryAll();
    $listIndikator = ArrayHelper::map($listIndikator,'id','indikator');

    echo $form->field($model, 'INDIKATOR')->widget(Select2::classname(), [
        'data' => $listIndikator,
        'options' => ['placeholder' => 'Jenis - Indikator'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    $listDiagnosa = DiagnosaKeperawatan::getListDiagnosa();

    echo $form->field($model, 'DIAGNOSA')->widget(Select2::classname(), [
        'data' => $listDiagnosa,
        'options' => ['placeholder' => 'Diagnosa'],
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
