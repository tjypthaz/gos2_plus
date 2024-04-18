<?php

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\PetugasAmbulan $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="petugas-ambulan-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    $listPegawai = ArrayHelper::map(Yii::$app->db_pembayaran
        ->createCommand("
        SELECT a.`ID`,a.`NAMA`
        FROM `master`.`pegawai` a
        WHERE a.`STATUS` = 1 
        ORDER BY a.`NAMA` ASC 
        ")->queryAll(),'ID','NAMA') ;

    echo $form->field($model, 'idPegawai')->widget(Select2::classname(), [
        'data' => $listPegawai,
        'options' => ['placeholder' => 'Ketikan Nama Pegawai'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'namaPetugas',
            [
                    'attribute' => 'id',
                'label' => 'Action',
                'value' => function($index){
                    return Html::a('Delete', ['delete', 'id' => $index['id'], 'idTagihanAmbulan' => Yii::$app->request->get('idTagihanAmbulan')], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]);
                },
                'format' => 'raw'
            ],
        ],
    ]); ?>

</div>
