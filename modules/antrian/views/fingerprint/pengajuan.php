<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Pengajuan Finger Print';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fingerprint-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <form action="<?=Url::to(['pengajuan','nomor' => $nomor])?>" method="post">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
        <div class="row">
            <div class="col-3">
                <input type="text" name="nomor" class="form-control" value="<?=$nomor?>" readonly="readonly" required />
            </div>
            <div class="col-7">
                <input type="text" name="alasan" class="form-control" value="" placeholder="Isikan Alasan Pengajuan" required />
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-success" id="cekPeserta">Kirim</button>
            </div>
        </div>
    </form>
</div>