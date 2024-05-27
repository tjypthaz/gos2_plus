<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\Kronis $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Upload Kronis';
$this->params['breadcrumbs'][] = ['label' => 'Kronis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <pre class="mt-0 pt-0">
    <h3>
Note :
1. Hanya menerima file Excel
2. Kolom yang digunakan hanya A, B & C
        A -> No Sep ( upperCase )
        B -> Tarif Kronis ( tanpa titik & koma )
        C -> klaim Kronis ( tanpa titik & koma )
3. Baris data mulai dari nomer 2
4. Pastikan tidak ada data double
    </h3>
    </pre>
<div class="kronis-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'fileExcel')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
