<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\PetugasAmbulan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="petugas-ambulan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idTagihanAmbulan')->textInput() ?>

    <?= $form->field($model, 'idPegawai')->textInput() ?>

    <?= $form->field($model, 'publish')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createDate')->textInput() ?>

    <?= $form->field($model, 'createBy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updateDate')->textInput() ?>

    <?= $form->field($model, 'updateBy')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
