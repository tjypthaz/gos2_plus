<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\Kronis $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kronis-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tarifKronis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'klaimKronis')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
