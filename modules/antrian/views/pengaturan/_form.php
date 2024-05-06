<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\Pengaturan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pengaturan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MULAI')->textInput() ?>

    <?= $form->field($model, 'BATAS_JAM_AMBIL')->textInput() ?>


    <?= $form->field($model, 'BATAS_MAX_HARI_BPJS')->textInput() ?>

    <?= $form->field($model, 'MATAS_MAX_HARI_KONTROL')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
