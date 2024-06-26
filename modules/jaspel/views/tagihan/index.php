<?php

use app\modules\jaspel\models\Jaspel;
use kartik\select2\Select2;
use yii\bootstrap4\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\grid\GridView;
/** @var yii\web\View $this */

$this->title = 'Data Tagihan RS';
$this->params['breadcrumbs'][] = $this->title;
$bulan = Yii::$app->session->get('bulan') ? Jaspel::getBulan(Yii::$app->session->get('bulan')) : '';
$this->params['breadcrumbs'][] = "Periode Jaspel : ".$bulan." ".Yii::$app->session->get('tahun');
?>
<div class="jaspel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container mb-3">
        <form class="row" action="" method="get">
            <div class="col">
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
                    <input type="date" name="tglAw" value="<?=Yii::$app->request->get('tglAw')?>" class="form-control">
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
                    <label for="">Id Register</label>
                    <input type="text" name="idReg" value="<?=Yii::$app->request->get('idReg')?>" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="date" name="tglAk" value="<?=Yii::$app->request->get('tglAk')?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Nomor RM</label>
                    <input type="text" name="noRm" value="<?=Yii::$app->request->get('noRm')?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Nomor SEP</label>
                    <input type="text" name="noSep" value="<?=Yii::$app->request->get('noSep')?>" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Periode Jaspel Bulan</label>
                    <?=Html::dropDownList('bulan',Yii::$app->request->get('bulan'),Jaspel::getBulan(),[
                            'prompt' => 'Pilih Bulan',
                        'class' => 'form-control'
                    ])?>
                </div>
                <div class="form-group">
                    <label for="">Periode Jaspel Tahun</label>
                    <?=Html::dropDownList('tahun',Yii::$app->request->get('tahun'),Jaspel::getTahun(),[
                        'prompt' => 'Pilih Tahun',
                        'class' => 'form-control'
                    ])?>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="unFinal" id="customCheck1"
                           <?=Yii::$app->request->get('unFinal')? "checked":""?>>
                    <label class="custom-control-label" for="customCheck1">Cari Jaspel Yang Belum Final</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <?php
    if($excelData != '[]'){
    $header = [
        'Id Reg',
        'No RM',
        'Nama pasien',
        'Tgl Daftar',
        'Id Ruangan',
        'Id Dokter',
        'Ruangan',
        'Dokter',
        'Id Cara Bayar',
        'Cara Bayar',
        'No SEP',
        'Id Tagihan',
        'Tagihan RS',
        'Klaim',
        'Periode'
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
    <div class="col text-right">
        <form action="<?= Url::toRoute(['laporan/toexcel'])?>" method="post">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
            <input type="hidden" name="namaFile" value="Rekap Klaim">
            <textarea name="excelData" style="display: none;">
                <?=$excelData?>
                </textarea>
            <textarea name="header" style="display: none;">
                <?=$header?>
                </textarea>
            <input type="submit" class="btn btn-outline-warning" value="Export EXCEL"  />
        </form>
    </div>
    <?php
    }
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'idReg',
                'value' => function ($index){
                    return Html::a($index['idReg'],Url::to(['detail-tagihan',
                        'idReg' => $index['idReg']
                    ]),[
                        'target' => '_blank',
                        'class' => 'btn btn-outline-success btn-sm',
                    ]);
                },
                'format' => 'raw'
            ],
            'noRm',
            'namaPasien',
            'tgl',
            [
                'attribute' => 'tujuan',
                'value' => function ($index){
                    return $index['tujuan']."<br>".$index['noSep'];
                },
                'format' => 'html'
            ],
            'caraBayar',
            [
                'attribute' => 'tagihanRs',
                'value' => function ($index){
                    return number_format($index['tagihanRs'],0,',','.');
                },
            ],
            [
                'attribute' => 'klaim',
                'value' => function ($index){
                    return number_format($index['klaim'],0,',','.');
                },
            ],
            'periode',
            /*[
                'attribute' => 'idReg',
                'label' => 'Action',
                'value' => function ($index){
                    return Html::a('Detail',Url::to(['detail-tagihan',
                            'idReg' => $index['idReg']
                            ]),[
                                'target' => '_blank',
                                'class' => 'btn btn-outline-success btn-sm',
                            ]);
                },
                'format' => 'raw'
            ],*/
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>

</div>
