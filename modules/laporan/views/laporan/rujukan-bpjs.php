<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Rujukan Pasien BPJS';
?>
<h1><?= Html::encode($this->title) ?></h1>
<?= "Message : ".$message?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'font-size:11px;'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'noKunjungan',
        'tglKunjungan',
        'tglHabisKunjungan',
        'diagnosa',
        'poliRujukan',
        'provPerujuk'
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
