<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\ParameterHasilToLoinc $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="parameter-hasil-to-loinc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PARAMETER_HASIL')->textInput(['readonly' => 'readonly']) ?>

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
            'allowClear' => true,
            'dropdownParent' => new JsExpression('$("#modal")'),
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
