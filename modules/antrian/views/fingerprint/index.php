<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Finger Print';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fingerprint-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-3">
            <input type="text" id="nomor" class="form-control" value="" autocomplete="off" placeholder="No BPJS / NIK" />
        </div>
        <div class="col-3">
            <button class="btn btn-success" id="cekPeserta">Cek Peserta</button>
        </div>
        <div class="col-3">
            <div style="display: none" id="isShowPengajuan">
                <button class="btn btn-primary" id="pengajuanFinger">Pengajuan Finger</button>
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
$urlCekPeserta = Url::to(['cek-peserta']);
$urlCekFinger = Url::to(['cek-finger']);
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
                    const jsonS = JSON.stringify(data,null,4);
                    $('#resultPeserta').html(jsonS);
                }
             });
            
            var url = '$urlCekFinger?nomor=' + nomor.val();
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data){
                    console.log(data.response.kode);
                    if(data.response.kode === "0"){
                        $('#isShowPengajuan').show();
                    }
                    const jsonS = JSON.stringify(data,null,4);
                    $('#resultCekFinger').html(jsonS);
                    
                }
             });
        }
        else{
            alert('Nomor BPJS / NIK Tidak Valid');
        }
        
    });
js;
$this->registerJs($js);
?>
