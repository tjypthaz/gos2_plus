<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\TagihanAmbulan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tagihan-ambulan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idJenisAmbulan')->textInput() ?>

    <?= $form->field($model, 'idTagihan')->textInput() ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <?= $form->field($model, 'noRm')->textInput() ?>

    <?= $form->field($model, 'namaPasien')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kilometer')->textInput() ?>

    <?= $form->field($model, 'jasaSarana')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jasaPelayanan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarif')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

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
