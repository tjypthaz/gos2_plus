<?php

use yii\bootstrap4\Html;

$this->title = 'Pendaftaran Mandiri';
$listJaminan = [
    1 => 'UMUM',
    5 => 'BPJS'
];
?>

<div class="row text-center">
    <div class="col">
        <h1>Formulir Pendaftaran "Mandiri"</h1>
        <div class="container border p-3">
            <div class="row">
                <div class="col">
                    Nomor RM<br>
                    <h3 class="font-weight-bold">
                        <?= str_pad($dataPasien['norm'],8,"0",STR_PAD_LEFT) ?>
                    </h3>
                </div>
                <div class="col">
                    Nama Pasien<br>
                    <h3 class="font-weight-bold">
                        <?= $dataPasien['nama'] ?>
                    </h3>
                </div>
                <div class="col">
                    Tanggal Lahir<br>
                    <h3 class="font-weight-bold">
                        <?= $dataPasien['tglLahir'] ?>
                    </h3>
                </div>
                <div class="col">
                    Jaminan<br>
                    <h3 class="font-weight-bold">
                        <?= $listJaminan[$jaminan] ?>
                    </h3>
                </div>
            </div>
            <?php
            if($jaminan == '5'){
                ?>
                <div class="row">
                    <div class="col">
                        Nomor Kontrol<br>
                        <h3 class="font-weight-bold">
                            <?= "asd" ?>
                        </h3>
                    </div>
                    <div class="col">
                        Nomor Rujukan<br>
                        <h3 class="font-weight-bold">
                            <?= "yyi" ?>
                        </h3>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <hr>
        <div class="container border">
            <form method="post" action="">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h4 class="font-weight-bold">Poli</h4>
                            <select class="form-control form-control-lg">
                                <option>Pilih Poli</option>
                                <option value="INT">Penyakit Dalam</option>
                                <option value="SAR">Saraf</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <h4 class="font-weight-bold">Dokter</h4>
                            <select class="form-control form-control-lg">
                                <option>Pilih Dokter</option>
                                <option value="11111">Dokter X</option>
                                <option value="22222">Dokter Y</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row pb-3">
                    <div class="col">
                        <button class="btn btn-success btn-lg">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>