<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\lis\models\search\MappingHasil $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mapping-hasil-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'VENDOR_LIS') ?>

    <?= $form->field($model, 'LIS_KODE_TEST') ?>

    <?= $form->field($model, 'PREFIX_KODE') ?>

    <?= $form->field($model, 'HIS_KODE_TEST') ?>

    <?php // echo $form->field($model, 'PARAMETER_TINDAKAN_LAB') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
