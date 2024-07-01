<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Finger Print';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fingerprint-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-3">
            <input type="text" id="nomor" class="form-control" value="<?=Yii::$app->request->get('nomor')?>" autocomplete="off" placeholder="No BPJS / NIK" />
        </div>
        <div class="col-3">
            <button class="btn btn-success" id="cekPeserta">Cek Peserta</button>
        </div>
        <div class="col-3">
            <div style="display: none" id="isShowPengajuan">
                <button class="btn btn-primary" value="" id="pengajuanFinger">
                    Pengajuan Finger
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <pre id="resultPeserta" class="col bg-info">
            Hasil cek peserta disini
        </pre>

        <pre id="resultCekFinger" class="col bg-warning">
            Hasil cek finger disini
        </pre>
    </div>
</div>

<?php
Modal::begin([
    //'header' => 'Modal',
    'id' => 'modal',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php
$urlCekPeserta = Url::to(['cek-peserta']);
$urlCekFinger = Url::to(['cek-finger']);
$urlPengajuan = Url::to(['pengajuan']);
$js= <<<js
    $('#cekPeserta').on('click', function () {
        const nomor = $('#nomor');
        const digitNomor = String(nomor).length;
        if(digitNomor === 12 || digitNomor === 15){
            var url = '$urlCekPeserta?nomor=' + nomor.val();
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data){
                    $('#isShowPengajuan').hide();
                    const jsonS = JSON.stringify(data,null,4);
                    $('#resultPeserta').html(jsonS);
                    
                    var url = '$urlCekFinger?nomor=' + nomor.val();
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(data){
                            console.log(data.response.kode);
                            if(data.response.kode === "0"){
                                $('#isShowPengajuan').show();
                                $('#pengajuanFinger').val('$urlPengajuan?nomor=' + nomor.val());
                            }
                            const jsonS = JSON.stringify(data,null,4);
                            $('#resultCekFinger').html(jsonS);                    
                        }
                     });
                }
             });
        }
        else{
            alert('Nomor BPJS / NIK Tidak Valid');
        }
        
    });

    $('#pengajuanFinger').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
?>
