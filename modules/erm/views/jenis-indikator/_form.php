<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\JenisIndikatorKeperawatan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jenis-indikator-keperawatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'DESKRIPSI')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
