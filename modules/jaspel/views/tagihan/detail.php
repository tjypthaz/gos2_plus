<?php

use app\modules\jaspel\models\Jaspel;
use kartik\select2\Select2;
use yii\bootstrap4\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
/** @var yii\web\View $this */

$this->title = 'Detail Tagihan';
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
                        <?=$data['idReg']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Tgl Daftar
                    </div>
                    <div class="col-8">
                        <?=$data['tgl']?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        No RM
                    </div>
                    <div class="col-8">
                        <?=$data['noRm']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Nama
                    </div>
                    <div class="col-8">
                        <?=$data['namaPasien']?>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-4">
                        Tujuan
                    </div>
                    <div class="col-8">
                        <?=$data['tujuan']?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        Cara Bayar
                    </div>
                    <div class="col-8">
                        <?=$data['caraBayar']?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if($data['periode'] == ''){
        ?>
        <form action="<?=Url::toRoute(['simpan-temp','idReg' => $data['idReg']])?>" method="post" >
            <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
            <input type="hidden" name="idReg" value="<?=$data['idReg']?>">
            <input type="hidden" name="idTagihan" value="<?=$data['idTagihan']?>">
            <input type="hidden" name="idBayar" value="<?=$data['idBayar']?>">
            <input type="hidden" name="noRm" value="<?=$data['noRm']?>">
            <input type="hidden" name="namaPasien" value="<?=$data['namaPasien']?>">
            <input type="hidden" name="caraBayar" value="<?=$data['caraBayar']?>">
            <input type="hidden" name="tgl" value="<?=$data['tgl']?>">
            <hr>
            <div class="row mb-1">
                <div class="col-3">
                    <div class="row">
                        <label class="col-sm-5 col-form-label">Bulan</label>
                        <div class="col-sm-7">
                            <input type="text" name="bulan" class="form-control" value="<?=Yii::$app->session->get('bulan')?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <label class="col-sm-5 col-form-label">Tahun</label>
                        <div class="col-sm-7">
                            <input type="text" name="tahun" class="form-control" value="<?=Yii::$app->session->get('tahun')?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" value="1" <?=$data['idBayar'] == '2' ? 'checked':''?> name="is_prop" role="switch" id="isProp">
                        <label class="form-check-label">Perhitungan Proporsional ?</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="row">
                        <label class="col-sm-5 col-form-label">Total Tarif RS</label>
                        <div class="col-sm-7">
                            <input type="text" name="tarifrs" class="form-control" value="<?=$data['tagihanRs']?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <label class="col-sm-5 col-form-label">Total Jaspel</label>
                        <div class="col-sm-7">
                            <input type="text" name="jaspel" class="form-control" value="<?=$data['totalJaspel']?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <label class="col-sm-5 col-form-label">Total Klaim</label>
                        <div class="col-sm-7">
                            <input type="text" name="klaim" id="klaim" class="form-control" autocomplete="off" value="<?=$data['idBayar'] == '2' ? $data['klaim']: $data['tagihanRs']?>" <?=$data['idBayar'] == '2' ? '':'readonly'?>>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <label class="col-sm-7 col-form-label">Jaspel Proporsional (%)</label>
                        <div class="col-sm-5">
                            <input type="text" name="jp_prop" id="jp_prop" class="form-control" value="<?php
                            if($data['idBayar'] == '2' && $data['idRuangan'] == '102010201')
                            { echo '15';}
                            else if($data['idBayar'] == '2')
                            { echo '40';}
                            else if($data['idBayar'] == '9')
                            { echo '45';}
                            else
                            { echo '0';}
                            ?>" <?=$data['idBayar'] == '2' || $data['idBayar'] == '9' ? '':'readonly'?>>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="text-end">
                    <input type="submit" value="Simpan" name="simpanjaspel" class="btn btn-success" >
                </div>
            </div>
        </form>
        <?php } ?>
    </div>
</div>
