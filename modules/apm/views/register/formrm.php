<?php

use yii\bootstrap4\Html;

$this->title = 'Pendaftaran Mandiri';
?>
<div class="row text-center">
    <div class="col">
        <form method="post" action="">
            <div class="form-group">
                <input type="hidden" value="<?=Yii::$app->request->get('jaminan')?>">
                <h1>Ketikan Nomor Rekam Medis</h1>
                <input type="text" autofocus class="form-control form-control-lg text-lg-center"
                       id="exampleInputEmail1" aria-describedby="emailHelp"
                       name="norm" autocomplete="off"
                >
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <small id="emailHelp" class="form-text text-muted">
                    Nomor Rekam Medis minimal 8 Digit
                </small>
            </div>
            <button type="submit" class="btn btn-success btn-lg">Cari Data Pasien</button>
        </form>
    </div>
</div>