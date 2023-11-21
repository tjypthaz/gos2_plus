<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\lis\models\search\Registration $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registration-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'patient_id') ?>

    <?= $form->field($model, 'visit_number') ?>

    <?= $form->field($model, 'order_number') ?>

    <?= $form->field($model, 'order_datetime') ?>

    <?= $form->field($model, 'diagnose_id') ?>

    <?php // echo $form->field($model, 'diagnose_name') ?>

    <?php // echo $form->field($model, 'service_unit_id') ?>

    <?php // echo $form->field($model, 'service_unit_name') ?>

    <?php // echo $form->field($model, 'guarantor_id') ?>

    <?php // echo $form->field($model, 'guarantor_name') ?>

    <?php // echo $form->field($model, 'agreement_id') ?>

    <?php // echo $form->field($model, 'agreement_name') ?>

    <?php // echo $form->field($model, 'doctor_id') ?>

    <?php // echo $form->field($model, 'doctor_name') ?>

    <?php // echo $form->field($model, 'class_id') ?>

    <?php // echo $form->field($model, 'class_name') ?>

    <?php // echo $form->field($model, 'ward_id') ?>

    <?php // echo $form->field($model, 'ward_name') ?>

    <?php // echo $form->field($model, 'room_id') ?>

    <?php // echo $form->field($model, 'room_name') ?>

    <?php // echo $form->field($model, 'bed_id') ?>

    <?php // echo $form->field($model, 'bed_name') ?>

    <?php // echo $form->field($model, 'reg_user_id') ?>

    <?php // echo $form->field($model, 'reg_user_name') ?>

    <?php // echo $form->field($model, 'lis_reg_no') ?>

    <?php // echo $form->field($model, 'retrieved_dt') ?>

    <?php // echo $form->field($model, 'retrieved_flag') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
