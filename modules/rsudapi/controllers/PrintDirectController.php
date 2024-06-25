<?php


namespace app\modules\rsudapi\controllers;


use yii\web\Controller;
use Yii;
use yii\web\Response;

class PrintDirectController extends Controller
{
    public function actionLabel()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $nOpen = Yii::$app->request->get('nOpen');
        if(!$nOpen){
            Yii::$app->response->statusCode = 400;
            return [
                'message' => 'Parameter tidak lengkap'
            ];
        }

        $data = Yii::$app->db_regonline->createCommand("
        SELECT LPAD(p.NORM,8,'0') NORM, CONCAT(master.getNamaLengkap(p.NORM),' (',IF(p.JENIS_KELAMIN=1,'L)','P)')) NAMALENGKAP
        , DATE_FORMAT(p.TANGGAL_LAHIR,'%d-%m-%Y') TGL_LAHIR, CONCAT('RM : ',LPAD(p.NORM,8,'0'),' Tgl Lhr '
        , DATE_FORMAT(p.TANGGAL_LAHIR,'%d-%m-%Y')) RMTGL_LAHIR, pd.NOMOR NOPEN, IF(p.JENIS_KELAMIN=1,'LAKI-LAKI','PEREMPUAN') JK
        , p.ALAMAT, kip.NOMOR NIK, master.getNamaLengkapPegawai(dr.NIP) DOKTER, DATE_FORMAT(pd.TANGGAL,'%d-%m-%Y') TGLMSK
        , ru.DESKRIPSI TUJUAN, rf.DESKRIPSI JAMINAN, pj.CATATAN
        , IF(pj.JENIS=2,IF(LOCATE('V',bk.noRujukan) > 0,'-',IF(LENGTH(bk.noRujukan) > 10,CONCAT(bk.noRujukan,' / ',DATE_ADD(DATE(bk.tglRujukan), INTERVAL 90 DAY)),'-')),'-') RUJUKAN
        FROM master.pasien p
        LEFT JOIN master.kartu_identitas_pasien kip ON p.NORM=kip.NORM
        LEFT JOIN pendaftaran.pendaftaran pd ON p.NORM=pd.NORM
        LEFT JOIN pendaftaran.tujuan_pasien tp ON pd.NOMOR=tp.NOPEN
        LEFT JOIN pendaftaran.`penjamin` pj ON pj.NOPEN = pd.NOMOR
        LEFT JOIN bpjs.`kunjungan` bk ON bk.noSEP = pj.NOMOR AND bk.status = 1
        LEFT JOIN master.referensi rf ON rf.JENIS = 10 AND pj.JENIS = rf.ID
        LEFT JOIN master.dokter dr ON tp.DOKTER=dr.ID
        LEFT JOIN master.`ruangan` ru ON ru.ID = tp.RUANGAN
        WHERE pd.NOMOR=:nOpen
        ")->bindValue(':nOpen',$nOpen)->queryOne();
        if($data){
            return [
                'message' => 'Ok',
                'data' => $data
            ];
        }

        Yii::$app->response->statusCode = 500;
        return [
            'message' => 'Error'
        ];
    }
}