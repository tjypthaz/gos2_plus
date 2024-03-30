<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\search\JaspelFinal $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jaspel-final-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'idJaspel') ?>

    <?= $form->field($model, 'idRuangan') ?>

    <?= $form->field($model, 'ruangan') ?>

    <?= $form->field($model, 'tindakan') ?>

    <?php // echo $form->field($model, 'idDokterO') ?>

    <?php // echo $form->field($model, 'idDokterL') ?>

    <?php // echo $form->field($model, 'idPara') ?>

    <?php // echo $form->field($model, 'namaDokterO') ?>

    <?php // echo $form->field($model, 'namaDokterL') ?>

    <?php // echo $form->field($model, 'jenisPara') ?>

    <?php // echo $form->field($model, 'jpDokterO') ?>

    <?php // echo $form->field($model, 'jpDokterL') ?>

    <?php // echo $form->field($model, 'jpPara') ?>

    <?php // echo $form->field($model, 'jpStruktural') ?>

    <?php // echo $form->field($model, 'jpBlud') ?>

    <?php // echo $form->field($model, 'jpPegawai') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
