<?php
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
            <b><h3>KWITANSI PEMBAYARAN</h3></b>
            <hr>
        </td>
    </tr>
</table>
<table style="width: 100%">
    <tr>
        <td style="width: 25%"><b>Telah Terima Dari</b></td>
        <td>: <?=$data->namaPasien?></td>
    </tr>
    <tr>
        <td><b>Untuk Pembayaran</b></td>
        <td>: <?=$data->idJenisAmbulan0->deskripsi?></td>
    </tr>
    <tr>
        <td><b>Nama Pasien (No RM)</b></td>
        <td>: <?=$data->namaPasien." (".$data->noRm.")"?></td>
    </tr>
    <tr>
        <td><b>Jumlah</b></td>
        <td>: Rp. <?=number_format($data->tarif,'0',',','.')?></td>
    </tr>
    <tr>
        <td><b>Terbilang</b></td>
        <td>: <?=ucwords(terbilang($data->tarif))." Rupiah";?></td>
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
        <td><?=$data->updateBy?></td>
    </tr>
</table>