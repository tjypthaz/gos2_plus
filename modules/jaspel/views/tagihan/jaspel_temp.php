<?php

use app\modules\jaspel\models\Jaspel;
use kartik\select2\Select2;
use yii\bootstrap4\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
/** @var yii\web\View $this */

$this->title = 'Jaspel Sementara';
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
                        Klaim INA
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
                <div class="row">
                    <div class="col-4">
                        Klaim Kronis
                    </div>
                    <div class="col-8">
                        Rp. <?=number_format($dataHeader['klaimKronis'],0,',','.')?>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row text-right">
            <a href="<?=Url::toRoute(['/jaspel/tagihan/hapus-jaspeltemp','id' => $dataHeader['id'],'idReg' => $dataHeader['idReg']])?>" onclick="return confirm('Tenane HAPUS ??')" class="btn btn-danger btn-sm mb-1">Hapus Perhitungan</a>
        </div>
        <?php
        $unFinish = 0;
        foreach ($dataTemp as $item) {
            if ($item['input'] > 0) {
                $unFinish++;
            }
        }

        if($unFinish > 0){
            ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>#</td>
                    <td>Unit</td>
                    <td>Tindakan</td>
                    <td>Dokter O</td>
                    <td>Dokter L</td>
                    <td>Paramedis</td>
                </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                foreach ($dataTemp as $item) {
                    if ($item['input'] > 0) {
                        $listDokterO = Yii::$app->db_jaspel
                            ->createCommand("SELECT a.`MEDIS`,c.`NAMA`
                            FROM layanan.`petugas_tindakan_medis` a
                            LEFT JOIN master.`dokter` b ON b.`ID` = a.`MEDIS`
                            LEFT JOIN master.`pegawai` c ON c.`NIP` = b.`NIP`
                            WHERE a.`TINDAKAN_MEDIS` = '".$item['idTindakanMedis']."' AND a.`STATUS` = 1 AND a.`JENIS` = 1 and a.`MEDIS` != 0
                            GROUP BY a.`MEDIS`")
                            ->queryAll();
                        if(count($listDokterO) > 0){
                            $listDokterO = ArrayHelper::map($listDokterO,'MEDIS','NAMA');
                        }else{
                            $listDokterO = $listDokter;
                        }
                        ?>
                        <tr>
                            <td><?=$i?></td>
                            <td><?=$item['ruangan']?></td>
                            <td><?=$item['tindakan']?></td>
                            <td>
                                <?php
                                if(intval($item['jpDokterO']) > 0){
                                    if($item['idDokterO'] > 0){
                                        echo $listDokter[$item['idDokterO']];
                                    }
                                    else{
                                        echo \yii\bootstrap4\Html::dropDownList('dokter', $item['idDokterO'], $listDokterO, [
                                            'class' => 'form-control pilihDokterO',
                                            'prompt' => 'Pilih Dokter',
                                            'id' => $item['id']
                                        ]);
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(intval($item['jpDokterL']) > 0){
                                    if($item['idDokterL'] > 0){
                                        echo $listDokter[$item['idDokterL']];
                                    }
                                    else{
                                        echo \yii\bootstrap4\Html::dropDownList('dokter', $item['idDokterL'], $listDokterO, [
                                            'class' => 'form-control pilihDokterL',
                                            'prompt' => 'Pilih Dokter',
                                            'id' => $item['id']
                                        ]);
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if(intval($item['jpPara']) > 0){
                                    if($item['idPara'] > 0){
                                        echo $listJenisPara[$item['idPara']];
                                    }
                                    else{
                                        echo \yii\bootstrap4\Html::dropDownList('paramedis', $item['idPara'], $listJenisPara, [
                                            'class' => 'form-control pilihParamedis',
                                            'prompt' => 'Pilih Paramedis',
                                            'id' => $item['id']
                                        ]);
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                }
                ?>
                </tbody>
            </table>
            <?php
        }
        ?>
        <hr>
        <div class="row">
            <div class="col">
                <b>Data Perhitungan Jaspel Sementara</b>
            </div>
            <div class="col text-right">
                <a href="<?=Url::toRoute(['/jaspel/tagihan/final-jaspeltemp','id' => $dataHeader['id'],'idReg' => $dataHeader['idReg']])?>" class="btn btn-success btn-sm mb-1">Final Perhitungan</a>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                <td>#</td>
                <td>Unit</td>
                <td>Tindakan</td>
                <td>Detail : Penerima | Tarif Jaspel -> Jaspel Fix</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $i=1;
            foreach ($dataTemp as $item){
                if($item['input'] < 1){
                    ?>
                    <tr>
                        <td><?=$i?></td>
                        <td><?=$item['ruangan']?></td>
                        <td><?=$item['tindakan']?></td>
                        <td>
                            <table style="font-size:10px;">
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
                                        <td class="p-0">&nbsp:&nbsp<?=number_format(intval($item['jpDokterO']),0,',','.')?> -> <?=number_format(intval($item['jpDokterOFix']),0,',','.')?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                if(intval($item['jpDokterL']) > 0){
                                    ?>
                                    <tr>
                                        <td class="p-0"><?=$item['idDokterL'] ? $listDokter[$item['idDokterL']] : ''?></td>
                                        <td class="p-0">&nbsp:&nbsp<?=number_format(intval($item['jpDokterL']),0,',','.')?> -> <?=number_format(intval($item['jpDokterLFix']),0,',','.')?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                if(intval($item['jpPara']) > 0){
                                    ?>
                                    <tr>
                                        <td class="p-0"><?=$item['idPara'] ? $listJenisPara[$item['idPara']] : ''?></td>
                                        <td class="p-0">&nbsp:&nbsp<?=number_format(intval($item['jpPara']),0,',','.')?> -> <?=number_format(intval($item['jpParaFix']),0,',','.')?></td>
                                    </tr>
                                    <?php
                                }
                                if(intval($item['jpAkomodasi']) > 0){
                                    ?>
                                    <tr>
                                        <td class="p-0">Akomodasi</td>
                                        <td class="p-0">&nbsp:&nbsp<?=number_format(intval($item['jpAkomodasi']),0,',','.')?> -> <?=number_format(intval($item['jpAkomodasiFix']),0,',','.')?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td class="p-0">Pegawai</td>
                                    <td class="p-0">&nbsp:&nbsp
                                        <?=number_format(intval($item['jpPegawai']),0,',','.')?> -> <?=number_format(intval($item['jpPegawaiFix']),0,',','.')?><br>
                                        JTLS -> <?=number_format(intval($item['jpSFix']),0,',','.')?><br>
                                        JTLB -> <?=number_format(intval($item['jpBFix']),0,',','.')?><br>
                                        JTLP -> <?=number_format(intval($item['jpPFix']),0,',','.')?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
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