<?php

use app\modules\erm\models\JenisIndikatorKeperawatan;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\IndikatorKeperawatan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="indikator-keperawatan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $listJenis = ArrayHelper::map(JenisIndikatorKeperawatan::find()->where('STATUS = 1')->all(),'ID','DESKRIPSI')?>
    <?= $form->field($model, 'JENIS')->dropDownList($listJenis,[
            'prompt' => 'Pilih Jenis Indikator Keperawatan'
    ]) ?>

    <?= $form->field($model, 'DESKRIPSI')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
