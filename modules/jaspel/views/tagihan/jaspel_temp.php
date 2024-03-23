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
$this->params['breadcrumbs'][] = "Periode Jaspel : ".Yii::$app->session->get('bulan')." ".Yii::$app->session->get('tahun');
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
                                    echo "tampil dropdown";
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
                                    echo "tampil dropdown";
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
                                        'class' => 'form-control',
                                        'prompt' => 'Pilih Paramedis'
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
        <hr>
        <strong>Data Perhitungan Jaspel Sementara</strong>
        <table class="table table-hover">
            <thead>
            <tr>
                <td>#</td>
                <td>Unit</td>
                <td>Tindakan</td>
                <td>Detail</td>
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
                            <table>
                                <!--<tr>
                                    <td>Penerima</td>
                                    <td>Tarif Jaspel</td>
                                    <td>Jaspel Fix</td>
                                </tr>-->
                                <?php
                                if(intval($item['jpDokterO']) > 0){
                                    ?>
                                    <tr>
                                        <td><?=$item['idDokterO'] ? $listDokter[$item['idDokterO']] : ''?></td>
                                        <td><?=number_format(intval($item['jpDokterO']),0,',','.')?></td>
                                        <td><?=number_format(intval($item['jpDokterOFix']),0,',','.')?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                if(intval($item['jpDokterL']) > 0){
                                    ?>
                                    <tr>
                                        <td><?=$item['idDokterL'] ? $listDokter[$item['idDokterL']] : ''?></td>
                                        <td><?=number_format(intval($item['jpDokterL']),0,',','.')?></td>
                                        <td><?=number_format(intval($item['jpDokterLFix']),0,',','.')?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <?php
                                if(intval($item['jpPara']) > 0){
                                    ?>
                                    <tr>
                                        <td><?=$item['idPara'] ? $listJenisPara[$item['idPara']] : ''?></td>
                                        <td><?=number_format(intval($item['jpPara']),0,',','.')?></td>
                                        <td><?=number_format(intval($item['jpParaFix']),0,',','.')?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td>Pegawai</td>
                                    <td><?=number_format(intval($item['jpPegawai']),0,',','.')?></td>
                                    <td><?=number_format(intval($item['jpPegawaiFix']),0,',','.')?></td>
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
