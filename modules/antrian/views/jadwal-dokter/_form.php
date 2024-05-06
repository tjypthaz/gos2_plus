<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\JadwalDokterHfis $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jadwal-dokter-hfis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NM_DOKTER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_HARI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KAPASITAS')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
