<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Laporan Reservasi MJKN';
?>
<h1><?= Html::encode($this->title) ?></h1>
<form method="get" action="">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Tanggal Reservasi Awal</label>
                <input type="date" name="tglAw" value="<?=Yii::$app->request->get('tglAw')?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="">Nomer RM</label>
                <input type="text" name="noRm" value="<?=Yii::$app->request->get('noRm')?>" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="">Tanggal Reservasi Akhir</label>
                <input type="date" name="tglAk" value="<?=Yii::$app->request->get('tglAk')?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Nama Pasien</label>
                <input type="text" name="namaPasien" value="<?=Yii::$app->request->get('namaPasien')?>" class="form-control">
            </div>


        </div>
        <div class="col">
            <?php
            $listRuangan = Yii::$app->db_jaspel
                ->createCommand("SELECT * FROM `master`.`ruangan` WHERE JENIS=5 AND `STATUS` = 1 order by ID asc")
                ->queryAll();
            $listRuangan = ArrayHelper::map($listRuangan,'ID','DESKRIPSI');
            ?>
            <div class="form-group">
                <label for="">Tujuan Poli</label>
                <?= Html::dropDownList('ruangan',Yii::$app->request->get('ruangan'),$listRuangan,[
                    'class' => 'form-control',
                    'prompt' => 'Pilih Tujuan'
                ])
                ?>
            </div>
            <?php
            $listDokter = Yii::$app->db_jaspel
                ->createCommand("SELECT *
            FROM regonline.dokter a
            WHERE a.`STATUS` = 1 ORDER BY a.`NAMA` ASC")
                ->queryAll();
            $listDokter = ArrayHelper::map($listDokter,'KODE','NAMA');
            ?>
            <div class="form-group">
                <label for="">Dokter</label>
                <?= Html::dropDownList('dokter',Yii::$app->request->get('dokter'),$listDokter,[
                    'class' => 'form-control',
                    'prompt' => 'Pilih Dokter'
                ])
                ?>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col text-right">
            <?=Html::button(Icon::show('search')." Cari Data",['class' => 'btn btn-success','type' => 'submit'])?>
        </div>
    </div>
</form>

<?php
if($excelData != '[]'){
    $header = [
        'No RM',
        'Nama pasien',
        'Tgl Lahir',
        'No Hp',
        'Tgl Buat',
        'Tgl Kontrol',
        'Tgl Reservasi',
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
        'noRm',
        'namaPasien',
        'tglLahir',
        'noHp',
        'createDate',
        'tglKontrol',
        'tglReservasi',
        'tujuan',
        'namaDokter',
        'noBooking',
        'noRef',
        'icd'
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
