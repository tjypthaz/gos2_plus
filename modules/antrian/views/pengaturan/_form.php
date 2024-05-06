<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\Pengaturan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pengaturan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'LIMIT_DAFTAR')->textInput() ?>

    <?= $form->field($model, 'DURASI')->textInput() ?>

    <?= $form->field($model, 'MULAI')->textInput() ?>

    <?= $form->field($model, 'BATAS_JAM_AMBIL')->textInput() ?>

    <?= $form->field($model, 'POS_ANTRIAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'BATAS_MAX_HARI')->textInput() ?>

    <?= $form->field($model, 'BATAS_MAX_HARI_BPJS')->textInput() ?>

    <?= $form->field($model, 'MATAS_MAX_HARI_KONTROL')->textInput() ?>

    <?= $form->field($model, 'UPDATE_TIME')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
