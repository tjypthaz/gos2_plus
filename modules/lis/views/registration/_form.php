<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\lis\models\Registration $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'patient_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'visit_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_datetime')->textInput() ?>

    <?= $form->field($model, 'diagnose_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diagnose_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_unit_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_unit_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantor_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'guarantor_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agreement_id')->textInput() ?>

    <?= $form->field($model, 'agreement_name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'doctor_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doctor_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ward_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ward_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'room_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'room_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bed_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bed_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reg_user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reg_user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lis_reg_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'retrieved_dt')->textInput() ?>

    <?= $form->field($model, 'retrieved_flag')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
