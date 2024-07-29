<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\DiagnosaKeperawatan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="diagnosa-keperawatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'KODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DESKRIPSI')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
