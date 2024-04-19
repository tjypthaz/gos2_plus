<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Laporan Detail Pengunjung';
?>
<h1><?= Html::encode($this->title) ?></h1>
<form class="row" method="get" action="">
    <div class="col">
        <div class="form-group">
            <label for="">Tanggal Awal</label>
            <input type="date" name="tglAw" value="<?=Yii::$app->request->get('tglAw')?>" class="form-control" required>
        </div>
        <?php
        $listCarabayar = Yii::$app->db_jaspel
            ->createCommand("SELECT * FROM `master`.`referensi` WHERE JENIS=10 AND `STATUS` = 1")
            ->queryAll();
        $listCarabayar = ArrayHelper::map($listCarabayar,'ID','DESKRIPSI');
        ?>
        <div class="form-group">
            <label for="">Cara Bayar</label>
            <?= Html::dropDownList('caraBayar',Yii::$app->request->get('caraBayar'),$listCarabayar,[
                'class' => 'form-control',
                'prompt' => 'Pilih Cara Bayar'
            ])
            ?>
        </div>
        <div class="form-group">
            <label for="">Nomer RM</label>
            <input type="text" name="noRm" value="<?=Yii::$app->request->get('noRm')?>" class="form-control">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="">Tanggal Akhir</label>
            <input type="date" name="tglAk" value="<?=Yii::$app->request->get('tglAk')?>" class="form-control">
        </div>
        <?php
        $listDokter = Yii::$app->db_jaspel
            ->createCommand("SELECT *
            FROM master.`pegawai` a
            WHERE a.`PROFESI` = 4 AND a.`STATUS` = 1 ORDER BY a.`NAMA` ASC")
            ->queryAll();
        $listDokter = ArrayHelper::map($listDokter,'NIP','NAMA');
        ?>
        <div class="form-group">
            <label for="">Dokter</label>
            <?= Html::dropDownList('dokter',Yii::$app->request->get('dokter'),$listDokter,[
                'class' => 'form-control',
                'prompt' => 'Pilih Dokter'
            ])
            ?>
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
            <label for="">Ruangan</label>
            <?= Html::dropDownList('ruangan',Yii::$app->request->get('ruangan'),$listRuangan,[
                'class' => 'form-control',
                'prompt' => 'Pilih Ruangan'
            ])
            ?>
        </div>
        <div class="form-group">
            <label for="">Belum ada SEP</label>
            <?=SwitchInput::widget(['name'=>'isSep', 'value' => Yii::$app->request->get('isSep') ? true : false]);?>
        </div>
        <div class="form-group">
            <br>
            <?=Html::button(Icon::show('search')." Cari Data",['class' => 'btn btn-success','type' => 'submit'])?>
        </div>
    </div>
</form>

<?php
if($excelData != '[]'){
    $header = [
        'Id Reg',
        'No RM',
        'Nama pasien',
        'Tgl Daftar',
        'Tujuan',
        'Dokter',
        'Cara Bayar',
        'No SEP',
        'Di Terima',
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
    <div class="row">
        <div class="col text-right">
            <form action="<?= Url::toRoute(['toexcel'])?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="namaFile" value="Detail Pengunjung">
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
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        //'idReg',
        [
            'attribute' => 'idReg',
            'value' => function ($index){
                return $index['idReg']."<br>".$index['tglDaftar'];
            },
            'format' => 'html'
        ],
        [
            'attribute' => 'noRm',
            'value' => function ($index){
                return $index['noRm']."<br>".$index['namaPasien'];
            },
            'format' => 'html'
        ],
        //'noRm',
        //'namaPasien',
        //'tglDaftar',
        [
            'attribute' => 'tujuan',
            'value' => function ($index){
                return $index['tujuan']."<br>".$index['dokter'];
            },
            'format' => 'html'
        ],
        //'tujuan',
        //'dokter',
        [
            'attribute' => 'caraBayar',
            'value' => function ($index){
                return $index['caraBayar']."<br>".$index['noSep'];
            },
            'format' => 'html'
        ],
        'diTerima'
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
