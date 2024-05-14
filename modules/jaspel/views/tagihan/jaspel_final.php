<?php

use app\modules\jaspel\models\Jaspel;
use kartik\select2\Select2;
use yii\bootstrap4\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
/** @var yii\web\View $this */

$this->title = 'Jaspel Final';
$this->params['breadcrumbs'][] = ['label' => 'Data Tagihan RS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "Periode Jaspel : ".Jaspel::getBulan(Yii::$app->session->get('bulan'))." ".Yii::$app->session->get('tahun');
?>
<div class="jaspel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        Id Daftar
                    </div>
                    <div class="col-8">
                        <?=$dataHeader['idReg']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Tgl Daftar
                    </div>
                    <div class="col-8">
                        <?=$dataHeader['tgl']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Total Tarif RS
                    </div>
                    <div class="col-8">
                        Rp. <?=number_format($dataHeader['tagihanRs'],0,',','.')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Total Klaim
                    </div>
                    <div class="col-8">
                        Rp. <?=number_format($dataHeader['klaim'],0,',','.')?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        No RM
                    </div>
                    <div class="col-8">
                        <?=$dataHeader['noRm']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Nama
                    </div>
                    <div class="col-8">
                        <?=$dataHeader['namaPasien']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Tarif Jaspel
                    </div>
                    <div class="col-8">
                        Rp. <?=number_format($dataHeader['jpRs'],0,',','.')?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Jaspel Fix
                    </div>
                    <div class="col-8">
                        Rp. <?=number_format($dataHeader['jpFix'],0,',','.')?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        Id Tagihan
                    </div>
                    <div class="col-8">
                        <?=$dataHeader['idTagihan']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Cara Bayar
                    </div>
                    <div class="col-8">
                        <?=$dataHeader['caraBayar']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Periode
                    </div>
                    <div class="col-8">
                        <?= Jaspel::getBulan($dataHeader['bulan'])." ".$dataHeader['tahun']?>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row text-right">
            <a href="<?=Url::toRoute(['/jaspel/tagihan/hapus-jaspeltemp','id' => $dataHeader['id'],'idReg' => $dataHeader['idReg']])?>" onclick="return confirm('Tenane HAPUS ??')" class="btn btn-danger btn-sm mb-1">Hapus Perhitungan</a>
        </div>
        <div class="row">
            <div class="col">
                <b>Data Perhitungan Jaspel Final</b>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                <td>#</td>
                <td>Unit</td>
                <td>Tindakan</td>
                <td>Detail : Penerima | Jaspel</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=1;
            foreach ($dataFinal as $item){
                ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$item['ruangan']?></td>
                    <td>
                        <?= \yii\bootstrap4\Html::a($item['tindakan'],['/jaspel/jaspel-final/update','id' => $item['id']],[
                                'class' => 'btn btn-danger',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Edit Dokter Klik Tombol INI !!',
                        ]) ?></td>
                    <td>
                        <table style="font-size:10px;" class="m-0 p-0">
                            <!--<tr>
                                <td>Penerima</td>
                                <td>Tarif Jaspel</td>
                                <td>Jaspel Fix</td>
                            </tr>-->
                            <?php
                            if(intval($item['jpDokterO']) > 0){
                                ?>
                                <tr>
                                    <td class="p-0"><?=$item['idDokterO'] ? $listDokter[$item['idDokterO']] : ''?></td>
                                    <td class="p-0">&nbsp: <?=number_format(intval($item['jpDokterO']),0,',','.')?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php
                            if(intval($item['jpDokterL']) > 0){
                                ?>
                                <tr>
                                    <td class="p-0"><?=$item['idDokterL'] ? $listDokter[$item['idDokterL']] : ''?></td>
                                    <td class="p-0">&nbsp: <?=number_format(intval($item['jpDokterL']),0,',','.')?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php
                            if(intval($item['jpPara']) > 0){
                                ?>
                                <tr>
                                    <td class="p-0"><?=$item['idPara'] ? $listJenisPara[$item['idPara']] : ''?></td>
                                    <td class="p-0">&nbsp: <?=number_format(intval($item['jpPara']),0,',','.')?></td>
                                </tr>
                                <?php
                            }
                            if(intval($item['jpAkomodasi']) > 0){
                                ?>
                                <tr>
                                    <td class="p-0">Akomodasi</td>
                                    <td class="p-0">&nbsp: <?=number_format(intval($item['jpAkomodasi']),0,',','.')?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td class="p-0">Struktural</td>
                                <td class="p-0">&nbsp: <?=number_format(intval($item['jpStruktural']),0,',','.')?></td>
                            </tr>
                            <tr>
                                <td class="p-0">Blud</td>
                                <td class="p-0">&nbsp: <?=number_format(intval($item['jpBlud']),0,',','.')?></td>
                            </tr>
                            <tr>
                                <td class="p-0">Pegawai</td>
                                <td class="p-0">&nbsp: <?=number_format(intval($item['jpPegawai']),0,',','.')?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$this->registerJs("
$('.pilihParamedis').change(function() {
    var d = $(this);
    var linkPost = '".Url::toRoute(['/jaspel/tagihan/pilih-para' ],true)."?id=' + d.attr('id') + '&jenis=' + d.val();
    //console.log(linkPost);
    $.get(linkPost, function(res){
        console.log(res);
    });
});
$('.pilihDokterO').change(function() {
    var d = $(this);
    var linkPost = '".Url::toRoute(['/jaspel/tagihan/pilih-dokter-o' ],true)."?id=' + d.attr('id') + '&idDokter=' + d.val();
    //console.log(linkPost);
    $.get(linkPost, function(res){
        console.log(res);
    });
});
$('.pilihDokterL').change(function() {
    var d = $(this);
    var linkPost = '".Url::toRoute(['/jaspel/tagihan/pilih-dokter-l' ],true)."?id=' + d.attr('id') + '&idDokter=' + d.val();
    //console.log(linkPost);
    $.get(linkPost, function(res){
        console.log(res);
    });
});
");
?>