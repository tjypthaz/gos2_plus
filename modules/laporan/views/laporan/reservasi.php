<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Laporan Reservasi';
?>
<h1><?= Html::encode($this->title) ?></h1>
<form class="row" method="get" action="">
    <div class="col-8">
        <div class="form-group">
            <label for="">Tanggal Reservasi</label>
            <input type="date" name="tglAw" value="<?=Yii::$app->request->get('tglAw')?>" class="form-control" required>
        </div>

    </div>
    <div class="col-4 text-right">
        <br>
        <div class="form-group">
            <?=Html::button(Icon::show('search')." Cari Data",['class' => 'btn btn-success','type' => 'submit'])?>
        </div>
    </div>
</form>

<?php
if($excelData != '[]'){
    $header = [
        'Jenis App',
        'No RM',
        'Nama pasien',
        'Tgl Lahir',
        'No Hp',
        'Tgl Buat',
        'Tgl Kontrol',
        'Tgl Reservasi',
        'Asal',
        'Tujuan',
        'Nama Dokter',
        'NOMOR BOOKING',
        'NOMOR REFERENSI',
        'ICD'
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
    <div class="row">
        <div class="col text-right">
            <form action="<?= Url::toRoute(['toexcel'])?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="namaFile" value="<?=$this->title?>">
                <textarea name="excelData" style="display: none;">
            <?=$excelData?>
            </textarea>
                <textarea name="header" style="display: none;">
            <?=$header?>
            </textarea>
                <button type="submit" class="btn btn-warning"><?=Icon::show('download')?> To EXCEL</button>
            </form>
        </div>
    </div>
    <?php
}
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'font-size:10px;'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'jenisApp',
        'NORM',
        'NAMA',
        'tglLahir',
        'noHp',
        'createDate',
        'tglKontrol',
        'tglReservasi',
        'asal',
        'tujuan',
        'namaDokter',
        'NOMOR_BOOKING',
        'NOMOR_REFERENSI',
        'ICD'
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
