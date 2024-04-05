<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\H2h $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="h2h-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idTagihan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'noRm')->textInput() ?>

    <?= $form->field($model, 'totalTagihan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bayar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publish')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createBy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createDate')->textInput() ?>

    <?= $form->field($model, 'updateBy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updateDate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
