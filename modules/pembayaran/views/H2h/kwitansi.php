<?php

use app\modules\pembayaran\models\H2h;

function terbilang($x) {
    $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

    if ($x < 12)
        return " " . $angka[$x];
    elseif ($x < 20)
        return terbilang($x - 10) . " belas";
    elseif ($x < 100)
        return terbilang($x / 10) . " puluh" . terbilang($x % 10);
    elseif ($x < 200)
        return "seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " ratus" . terbilang($x % 100);
    elseif ($x < 2000)
        return "seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
}
?>
<table width="100%">
    <tr>
        <td align="center">
            <b><h3>TAGIHAN H2H</h3></b>
            <hr>
        </td>
    </tr>
</table>
<table style="width: 100%">
    <tr>
        <td style="width: 25%"><b>Id Tagihan</b></td>
        <td>: <?=$data['idTagihan']?></td>
    </tr>
    <tr>
        <td><b>Nomor RM</b></td>
        <td>: <?=$data['NORM']?></td>
    </tr>
    <tr>
        <td><b>Nama Pasien</b></td>
        <td>: <?=$data['NAMA']." (".$data['JENIS_KELAMIN'].")"?></td>
    </tr>
    <tr>
        <td><b>Tanggal Lahir</b></td>
        <td>: <?=$data['TANGGAL_LAHIR']." ( ".$data['umur']." tahun )"?></td>
    </tr>
    <tr>
        <td><b>Alamat</b></td>
        <td>: <?=$data['ALAMAT']?></td>
    </tr>
    <tr>
        <td><b>Jumlah Tagihan</b></td>
        <td>: Rp. <?=number_format($data['totalTagihan'],'0',',','.')?></td>
    </tr>
    <tr>
        <td><b>Status Tagihan</b></td>
        <td>: <?= H2h::getStatus($data['status']);?></td>
    </tr>
</table>
<br><br>
<table style="width: 100%">
    <tr>
        <td style="width: 70%"></td>
        <td>Purworejo, <?=date('d - m - Y')?></td>
    </tr>
    <tr>
        <td></td>
        <td>Petugas Kasir,</td>
    </tr>
    <tr>
        <td></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td></td>
        <td><?=$data['createBy']?></td>
    </tr>
</table>