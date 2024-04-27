<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\berkas\models\search\TerimaBerkas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="terima-berkas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'NOPEN') ?>

    <?= $form->field($model, 'TGL_TERIMA') ?>

    <?= $form->field($model, 'TERIMA') ?>

    <?= $form->field($model, 'KETERANGAN') ?>

    <?php // echo $form->field($model, 'KASUS_KHUSUS') ?>

    <?php // echo $form->field($model, 'INFORMED_CONSENT') ?>

    <?php // echo $form->field($model, 'RESUME_MEDIS') ?>

    <?php // echo $form->field($model, 'TGL_KEMBALI') ?>

    <?php // echo $form->field($model, 'RUANGAN_KEMBALI') ?>

    <?php // echo $form->field($model, 'OLEH') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
