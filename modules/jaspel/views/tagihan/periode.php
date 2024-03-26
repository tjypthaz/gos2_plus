<?php

use app\modules\jaspel\models\Jaspel;
use kartik\select2\Select2;
use yii\bootstrap4\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'Setting Periode';
$this->params['breadcrumbs'][] = ['label' => 'Data Tagihan RS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "Periode Jaspel : ".Yii::$app->session->get('bulan')." ".Yii::$app->session->get('tahun');
?>
<div class="jaspel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'bulan')->dropDownList(Jaspel::getBulan(),[
                'prompt' => 'Pilih Bulan'
            ]) ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'tahun')->dropDownList(Jaspel::getTahun(),[
                'prompt' => 'Pilih Tahun'
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
