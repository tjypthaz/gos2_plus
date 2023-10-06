<?php

use yii\bootstrap4\Html;

$this->title = 'Pendaftaran Mandiri';
?>
<div class="row text-center">
    <div class="col">
        <h1>Pilih Rujukan Faskes 1</h1>
        <?php
        foreach ($listRujukan as $rujukan){
            echo Html::a($rujukan['poli'],[
                'register/form-reg',
                'noRujukan' => $rujukan['norujukan'],
                'norm' => $norm,
                'jaminan' => $jaminan
            ],[
                    'class' => 'btn btn-success btn-lg btn-block'
            ]);
        }
        ?>
    </div>
</div>