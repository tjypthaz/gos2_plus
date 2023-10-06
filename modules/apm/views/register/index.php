<?php

use yii\bootstrap4\Html;

$this->title = 'Pendaftaran Mandiri';
?>
<div class="row text-xl-center">
    <div class="col">
        <h1>Pilih Jaminan</h1>
    </div>
</div>
<div class="row text-center ">
    <div class="col p-2 border border-success">
        <?= Html::a('<h1>BPJS</h1>', ['register/form-rm', 'jaminan' => 5], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="col p-2 border border-success">
        <?= Html::a('<h1>UMUM</h1>', ['register/form-rm', 'jaminan' => 1], ['class' => 'btn btn-success']) ?>
    </div>
</div>
