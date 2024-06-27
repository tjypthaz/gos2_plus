<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$deskTipe = $type == '1' ? 'Berdasarkan Tanggal Terbit' : 'Berdasarkan Tanggal Rencana';
$periode = date('M Y');
$this->title = 'Kontrol Pasien BPJS '.$deskTipe.' '.$periode;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?= "Message : ".$message?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'font-size:11px;'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'noSuratKontrol',
        'jnsPelayanan',
        'tglRencanaKontrol',
        'tglTerbitKontrol',
        'noSepAsalKontrol',
        [
                'attribute' => 'namaPoliTujuan',
            'value' => function($index){
                return $index['namaPoliTujuan'].' - '.$index['namaDokter'];
            }
        ],
        'terbitSEP',
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
