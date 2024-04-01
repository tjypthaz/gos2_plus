<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\JenisAmbulan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jenis-ambulan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'deskripsi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jsProp')->textInput() ?>

    <?= $form->field($model, 'jpProp')->textInput() ?>

    <?= $form->field($model, 'hargaPerKM')->textInput() ?>

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
