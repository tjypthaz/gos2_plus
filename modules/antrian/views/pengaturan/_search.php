<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\antrian\models\search\Pengaturan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="pengaturan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'LIMIT_DAFTAR') ?>

    <?= $form->field($model, 'DURASI') ?>

    <?= $form->field($model, 'MULAI') ?>

    <?= $form->field($model, 'BATAS_JAM_AMBIL') ?>

    <?php // echo $form->field($model, 'POS_ANTRIAN') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'BATAS_MAX_HARI') ?>

    <?php // echo $form->field($model, 'BATAS_MAX_HARI_BPJS') ?>

    <?php // echo $form->field($model, 'MATAS_MAX_HARI_KONTROL') ?>

    <?php // echo $form->field($model, 'UPDATE_TIME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
