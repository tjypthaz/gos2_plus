<?php

use app\modules\erm\models\IndikatorKeperawatan;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\MappingIntervensiIndikator $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mapping-intervensi-indikator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $listIntervensi = IndikatorKeperawatan::getListIntervensi();

    echo $form->field($model, 'INTERVENSI')->widget(Select2::classname(), [
        'data' => $listIntervensi,
        'options' => ['placeholder' => 'Intervensi'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    $listIndikator = Yii::$app->db_erm->createCommand("
    SELECT CONCAT(a.`JENIS`,'-',a.`ID`) id,CONCAT(b.`DESKRIPSI`,' - ',a.`DESKRIPSI`) indikator 
    FROM `medicalrecord`.`indikator_keperawatan` a
    LEFT JOIN `medicalrecord`.`jenis_indikator_keperawatan` b ON b.`ID` = a.`JENIS`
    WHERE a.`STATUS` = 1 and a.JENIS IN (6,7,8,9)
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
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
