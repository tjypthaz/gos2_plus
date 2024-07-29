<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\search\IndikatorKeperawatan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="indikator-keperawatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'JENIS') ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'DESKRIPSI') ?>

    <?= $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
