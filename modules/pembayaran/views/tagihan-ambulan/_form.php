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
            <?= $form->field($model, 'idTagihan')->textInput() ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'idJenisAmbulan')->dropDownList(\app\modules\pembayaran\models\TagihanAmbulan::getJenisAmbulan(),[
                'prompt' => 'Pilih Jenis Pelayanan'
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'noRm')->textInput() ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'tanggal')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'namaPasien')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'kilometer')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
