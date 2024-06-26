<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\TagihanAmbulan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tagihan-ambulan-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col">
            <?= $form->field($model, 'idTagihan')->textInput([
                    'disabled' => 'disabled'
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'idJenisAmbulan')->dropDownList(\app\modules\pembayaran\models\TagihanAmbulan::getJenisAmbulan(),[
                'prompt' => 'Pilih Jenis Pelayanan'
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'noRm')->textInput([
                'disabled' => 'disabled'
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'tanggal')->textInput([
                    'type' => 'date'
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'namaPasien')->textInput([
                    'maxlength' => true,
                'disabled' => 'disabled'
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'kilometer')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
