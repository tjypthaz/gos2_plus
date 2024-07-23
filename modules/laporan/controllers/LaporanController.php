<?php

namespace app\modules\laporan\controllers;

use LZCompressor\LZString;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\web\Controller;

/**
 * Default controller for the `laporan` module
 */
class LaporanController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionDetailPengunjung()
    {
        // list dokter
        // list ruangan
        // tanggal daftar
        // no rm
        // cara bayar
        // is_SEP
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) = '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) between '".$tglAw."' and '".$tglAk."'";
        }

        $filterRm = "";
        $noRm = Yii::$app->request->get('noRm');
        if($noRm != ""){
            $filterRm = " and a.`NORM` = '".$noRm."'";
        }

        $filterNama = "";
        $namaPasien = Yii::$app->request->get('namaPasien');
        if($namaPasien != ""){
            $filterNama = " and b.`NAMA` like '%".$namaPasien."%'";
        }

        $filterCb = "";
        $caraBayar = Yii::$app->request->get('caraBayar');
        if($caraBayar != ""){
            $filterCb = " and g.`JENIS` = '".$caraBayar."'";
        }

        $filterRuang = "";
        $ruangan = Yii::$app->request->get('ruangan');
        if($ruangan != ""){
            $filterRuang = " and c.`RUANGAN` = '".$ruangan."'";
        }

        $filterDokter = "";
        $dokter = Yii::$app->request->get('dokter');
        if($dokter != ""){
            $filterDokter = " and e.`NIP` = '".$dokter."'";
        }

        $filterNoSep = "";
        $noSep= Yii::$app->request->get('noSep');
        if($noSep != ""){
            $filterNoSep = " and g.`NOMOR` = '".$noSep."'";
        }

        $filterNs = "";
        $isSep = Yii::$app->request->get('isSep');
        if($isSep != ""){
            $filterNs = " and (g.`NOMOR` = '' or g.`NOMOR` is null)";
        }

        $filterjenis = "";
        $jenis = Yii::$app->request->get('jenis');
        if($jenis != ""){
            if($jenis == '1'){ //rajal
                $filterjenis = " AND d.`JENIS_KUNJUNGAN` IN (1,4,5,7)";
            }
            elseif ($jenis == '2'){ // ranap
                $filterjenis = " AND d.`JENIS_KUNJUNGAN` = 3";
            }
            elseif ($jenis == '3'){ // igd
                $filterjenis = " AND d.`JENIS_KUNJUNGAN` = 2";
            }
        }

        $filter = $filterTgl.$filterRm.$filterCb.$filterRuang.$filterDokter.$filterNs.$filterNama.$filterjenis.$filterNoSep;
        $data=[];
        if($filter){
            $data = Yii::$app->db_pembayaran->createCommand("
            SELECT a.`NOMOR` idReg,a.`NORM` noRm,b.`NAMA` namaPasien,DATE(a.`TANGGAL`) tglDaftar,d.`DESKRIPSI` tujuan
            ,f.`NAMA` dokter,h.`DESKRIPSI` caraBayar,g.`NOMOR` noSep
            ,if(c.`STATUS` = '1', 'Belum','Sudah') diTerima,if(a.`STATUS` = '1', 'Aktif','Selesai') `status`
            FROM `pendaftaran`.`pendaftaran` a
            LEFT JOIN `master`.`pasien` b ON b.`NORM` = a.`NORM`
            LEFT JOIN `pendaftaran`.`tujuan_pasien` c ON c.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`ruangan` d ON d.`ID` = c.`RUANGAN`
            LEFT JOIN `master`.`dokter` e ON e.`ID` = c.`DOKTER`
            LEFT JOIN `master`.`pegawai` f ON f.`NIP` = e.`NIP`
            LEFT JOIN `pendaftaran`.`penjamin` g ON g.`NOPEN` = a.`NOMOR`
            LEFT JOIN (SELECT * FROM `master`.`referensi` WHERE JENIS = 10) h ON h.ID = g.`JENIS`
            WHERE a.`STATUS` != 0 AND c.`STATUS` != 0
            ".$filter."
            ")->queryAll();
        }
        $excelData = htmlspecialchars(Json::encode($data));
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['noRm','namaPasien','tglDaftar','tujuan','dokter','caraBayar','diTerima','status'],
            ],
        ]);

        return $this->render('detail-pengunjung',[
            'dataProvider' => $provider,
            'excelData' => $excelData
        ]);
    }

    public function actionRekapKunjungan()
    {
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " DATE(a.`TANGGAL`) = '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " DATE(a.`TANGGAL`) between '".$tglAw."' and '".$tglAk."'";
        }

        $filter = $filterTgl;
        $dataAsalRujukan=[];
        $dataJenisKunjungan=[];
        $dataTriase=[];
        $totalPasien = 0;
        if($filter){
            $dataAsalRujukan = Yii::$app->db_pembayaran->createCommand("
            SELECT IF(a.JENIS = 0,'Datang Sendiri',IFNULL(b.`DESKRIPSI`,'Tidak Diketahui')) asalRujukan,a.jumlah
            FROM 
            (
                SELECT 0 `JENIS`,COUNT(a.`NOMOR`) jumlah
                FROM `pendaftaran`.`pendaftaran` a
                LEFT JOIN `pendaftaran`.`surat_rujukan_pasien` b ON b.`ID` = a.`RUJUKAN` AND b.`STATUS` = 1
                LEFT JOIN `master`.`ppk` c ON c.`ID` = b.`PPK`
                LEFT JOIN `pendaftaran`.`tujuan_pasien` d ON d.`NOPEN` = a.`NOMOR`
                LEFT JOIN `master`.`ruangan`e ON e.`ID` = d.`RUANGAN`
                LEFT JOIN `pendaftaran`.`kunjungan` f ON f.`NOPEN` = a.`NOMOR` AND d.`RUANGAN` = f.`RUANGAN` AND f.`STATUS` = 2
                WHERE ".$filter."
                AND a.`STATUS` IN (1,2) AND b.`PPK` = 26491 AND e.`JENIS_KUNJUNGAN` IN (1,2,4,5,7) 
                AND f.`NOMOR` IS NOT NULL
                UNION ALL 
                SELECT IFNULL(c.`JENIS`,99),COUNT(a.`NOMOR`) jumlah
                FROM `pendaftaran`.`pendaftaran` a
                LEFT JOIN `pendaftaran`.`surat_rujukan_pasien` b ON b.`ID` = a.`RUJUKAN` AND b.`STATUS` = 1
                LEFT JOIN `master`.`ppk` c ON c.`ID` = b.`PPK`
                LEFT JOIN `pendaftaran`.`tujuan_pasien` d ON d.`NOPEN` = a.`NOMOR`
                LEFT JOIN `master`.`ruangan`e ON e.`ID` = d.`RUANGAN`
                LEFT JOIN `pendaftaran`.`kunjungan` f ON f.`NOPEN` = a.`NOMOR` AND d.`RUANGAN` = f.`RUANGAN` AND f.`STATUS` = 2
                WHERE ".$filter."
                AND a.`STATUS` IN (1,2) AND b.`PPK` <> 26491 AND e.`JENIS_KUNJUNGAN` IN (1,2,4,5,7)
                AND f.`NOMOR` IS NOT NULL
                GROUP BY c.`JENIS`
            ) a
            LEFT JOIN `master`.`referensi` b ON a.JENIS = b.`ID` AND b.`STATUS` = 1 AND b.`JENIS` = 11
            ORDER BY a.JENIS ASC
            ")->queryAll();

            $dataJenisKunjungan = Yii::$app->db_pembayaran->createCommand("
            SELECT b.`DESKRIPSI` jenisKunjungan, a.jumlah
            FROM (
                SELECT c.`JENIS_KUNJUNGAN`, COUNT(a.`NOMOR`) jumlah
                FROM `pendaftaran`.`pendaftaran` a
                LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
                LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
                LEFT JOIN `pendaftaran`.`kunjungan` d ON d.`NOPEN` = a.`NOMOR` AND b.`RUANGAN` = d.`RUANGAN` AND d.`STATUS` = 2
                WHERE ".$filter."
                AND a.`STATUS` IN (1,2) AND c.`JENIS_KUNJUNGAN` IN (1,2,4,5,7)
                AND d.`NOMOR` IS NOT NULL 
                GROUP BY c.`JENIS_KUNJUNGAN`
            ) a
            LEFT JOIN `master`.`referensi` b ON b.`ID` = a.JENIS_KUNJUNGAN AND b.`JENIS` = 15
            ORDER BY b.`ID` ASC
            ")->queryAll();

            $totalPasien = Yii::$app->db_pembayaran->createCommand("
            SELECT COUNT(a.`NOMOR`) jumlah
            FROM `pendaftaran`.`pendaftaran` a
            LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
            LEFT JOIN `pendaftaran`.`kunjungan` d ON d.`NOPEN` = a.`NOMOR` AND b.`RUANGAN` = d.`RUANGAN` AND d.`STATUS` = 2
            WHERE ".$filter."
            AND a.`STATUS` IN (1,2) AND c.`JENIS_KUNJUNGAN` IN (1,2,4,5,7)
            AND d.`NOMOR` IS NOT NULL
            ")->queryScalar();
        }
        $providerAsalRujukan = new ArrayDataProvider([
            'allModels' => $dataAsalRujukan,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [],
            ],
        ]);

        $providerJenisKunjungan = new ArrayDataProvider([
            'allModels' => $dataJenisKunjungan,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [],
            ],
        ]);

        return $this->render('rekap-kunjungan',[
            'totalPasien' => $totalPasien,
            'dataProviderAsalRujukan' => $providerAsalRujukan,
            'dataProviderJenisKunjungan' => $providerJenisKunjungan,
        ]);
    }

    public function actionRekapTriage(){
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " DATE(a.`TANGGAL`) = '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " DATE(a.`TANGGAL`) between '".$tglAw."' and '".$tglAk."'";
        }

        $filter = $filterTgl;
        $dataTriase=[];
        $dataAsalRujukan=[];
        $dataSmf=[];
        if($filter){
            $dataTriase = Yii::$app->db_pembayaran->createCommand("
            SELECT SUM(RESUSITASI) RESUSITASI,SUM(EMERGENCY) EMERGENCY,SUM(URGENT) URGENT,SUM(LESS_URGENT) LESS_URGENT,SUM(NON_URGENT) NON_URGENT
            ,SUM(DOA) DOA,SUM(tidakDiketahui) tidakDiketahui
            FROM (
                SELECT IFNULL(e.`RESUSITASI` -> '$.CHECKED',0) RESUSITASI,IFNULL(e.`EMERGENCY` -> '$.CHECKED',0) EMERGENCY
                ,IFNULL(e.`URGENT` -> '$.CHECKED',0) URGENT,IFNULL(e.`LESS_URGENT` -> '$.CHECKED',0) LESS_URGENT
                ,IFNULL(e.`NON_URGENT` -> '$.CHECKED',0) NON_URGENT,IFNULL(e.`DOA` -> '$.CHECKED',0) DOA, 0 tidakDiketahui
                FROM `pendaftaran`.`pendaftaran` a
                LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
                LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
                LEFT JOIN `pendaftaran`.`kunjungan` d ON d.`NOPEN` = a.`NOMOR` AND b.`RUANGAN` = d.`RUANGAN` AND d.`STATUS` = 2
                LEFT JOIN `medicalrecord`.`triage` e ON e.`NOPEN` = a.`NOMOR`
                WHERE ".$filter."
                AND a.`STATUS` IN (1,2) AND c.`JENIS_KUNJUNGAN` = 2
                AND d.`NOMOR` IS NOT NULL
                UNION ALL
                SELECT 0 RESUSITASI,0 EMERGENCY,0 URGENT,0 LESS_URGENT,0 NON_URGENT,0 DOA,COUNT(a.`NOMOR`) tidakDiketahui
                FROM `pendaftaran`.`pendaftaran` a
                LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
                LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
                LEFT JOIN `pendaftaran`.`kunjungan` d ON d.`NOPEN` = a.`NOMOR` AND b.`RUANGAN` = d.`RUANGAN` AND d.`STATUS` = 2
                LEFT JOIN `medicalrecord`.`triage` e ON e.`NOPEN` = a.`NOMOR`
                WHERE ".$filter."
                AND a.`STATUS` IN (1,2) AND c.`JENIS_KUNJUNGAN` = 2
                AND d.`NOMOR` IS NOT NULL 
                AND ((e.`RESUSITASI` -> '$.CHECKED' = 0 
                AND e.`EMERGENCY` -> '$.CHECKED' = 0 
                AND e.`URGENT` -> '$.CHECKED' = 0 
                AND e.`LESS_URGENT` -> '$.CHECKED' = 0 
                AND e.`NON_URGENT` -> '$.CHECKED' = 0 
                AND e.`DOA` -> '$.CHECKED' = 0) OR e.`ID` IS NULL)
            )a
            ")->queryAll();

            $dataAsalRujukan = Yii::$app->db_pembayaran->createCommand("
            SELECT if(a.JENIS = 1,'Datang Sendiri',if(a.JENIS = 2,'Rujukan Dari',if(a.JENIS = 3,'Polisi Dari','Tidak Diketahui'))) jenis,b.NAMA faskes,COUNT(idReg) jml
            FROM (
                SELECT e.`KEDATANGAN` ->> '$.JENIS' JENIS,e.`KEDATANGAN` ->> '$.ASAL_RUJUKAN' ASAL_RUJUKAN,a.NOMOR idReg
                FROM `pendaftaran`.`pendaftaran` a 
                LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
                LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
                LEFT JOIN `pendaftaran`.`kunjungan` d ON d.`NOPEN` = a.`NOMOR` AND b.`RUANGAN` = d.`RUANGAN` AND d.`STATUS` = 2
                LEFT JOIN `medicalrecord`.`triage` e ON e.`NOPEN` = a.`NOMOR`
                WHERE ".$filter." 
                AND a.`STATUS` IN (1,2) AND c.`JENIS_KUNJUNGAN` = 2
                AND d.`NOMOR` IS NOT NULL
            )a
            LEFT JOIN master.`ppk` b ON b.ID = a.ASAL_RUJUKAN
            GROUP BY a.JENIS,b.NAMA
            ")->queryAll();

            $dataSmf = Yii::$app->db_pembayaran->createCommand("
            SELECT IFNULL(g.`DESKRIPSI`,'Umum') SMF,COUNT(a.`NOMOR`) jml
            FROM `pendaftaran`.`pendaftaran` a 
            LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
            LEFT JOIN `pendaftaran`.`kunjungan` d ON d.`NOPEN` = a.`NOMOR` AND b.`RUANGAN` = d.`RUANGAN` AND d.`STATUS` = 2
            LEFT JOIN `medicalrecord`.`perencanaan_rawat_inap` e ON e.`KUNJUNGAN` = d.`NOMOR` AND e.`STATUS` = 1
            LEFT JOIN `master`.`dokter_smf` f ON f.`DOKTER` = e.`DOKTER` AND f.`STATUS` = 1
            LEFT JOIN `master`.`referensi` g ON g.`ID` = f.`SMF` AND g.`JENIS` = 26
            WHERE ".$filter." 
            AND a.`STATUS` IN (1,2) AND c.`JENIS_KUNJUNGAN` = 2
            AND d.`NOMOR` IS NOT NULL
            GROUP BY f.`SMF`
            ")->queryAll();
        }
        $excelDataTriase = htmlspecialchars(Json::encode($dataTriase));
        $excelDataAsalRujukan = htmlspecialchars(Json::encode($dataAsalRujukan));
        $excelDataSmf = htmlspecialchars(Json::encode($dataSmf));

        $providerTriase = new ArrayDataProvider([
            'allModels' => $dataTriase,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [],
            ],
        ]);
        $providerAsalRujukan = new ArrayDataProvider([
            'allModels' => $dataAsalRujukan,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['jenis','jml'],
            ],
        ]);
        $providerSmf = new ArrayDataProvider([
            'allModels' => $dataSmf,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['jenis','jml'],
            ],
        ]);

        return $this->render('rekap-triage',[
            'providerTriase' => $providerTriase,
            'providerAsalRujukan' => $providerAsalRujukan,
            'providerSmf' => $providerSmf,
            'excelDataTriase' => $excelDataTriase,
            'excelDataAsalRujukan' => $excelDataAsalRujukan,
            'excelDataSmf' => $excelDataSmf,
        ]);
    }

    public function actionPasienPulang()
    {
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) = '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) between '".$tglAw."' and '".$tglAk."'";
        }

        $filterRm = "";
        $noRm = Yii::$app->request->get('noRm');
        if($noRm != ""){
            $filterRm = " and b.`NORM` = '".$noRm."'";
        }

        $filterNama = "";
        $namaPasien = Yii::$app->request->get('namaPasien');
        if($namaPasien != ""){
            $filterNama = " and e.`NAMA` like '%".$namaPasien."%'";
        }

        $filterCb = "";
        $caraBayar = Yii::$app->request->get('caraBayar');
        if($caraBayar != ""){
            $filterCb = " and f.`JENIS` = '".$caraBayar."'";
        }

        $filterRuang = "";
        $ruangan = Yii::$app->request->get('ruangan');
        if($ruangan != ""){
            $filterRuang = " and c.`RUANGAN` = '".$ruangan."'";
        }
        $filter = $filterTgl.$filterRm.$filterCb.$filterRuang.$filterNama;
        $data=[];
        if($filter){
            $data = Yii::$app->db_pembayaran->createCommand("
            SELECT b.`NOMOR` idReg,b.`NORM` noRm,e.`NAMA` namaPasien,d.`DESKRIPSI` ruangan,g.`DESKRIPSI` caraBayar
                 ,f.`NOMOR` noSep,b.`TANGGAL` tglDaftar,a.`TANGGAL` tglPulang,h.`TGL_TERIMA` tglKembali
            FROM `layanan`.`pasien_pulang` a
            LEFT JOIN `pendaftaran`.`pendaftaran` b ON b.`NOMOR` = a.`NOPEN`
            LEFT JOIN `pendaftaran`.`kunjungan` c ON c.`NOMOR` = a.`KUNJUNGAN` AND c.`NOPEN` = a.`NOPEN`
            LEFT JOIN `master`.`ruangan` d ON d.`ID` = c.`RUANGAN`
            LEFT JOIN `master`.`pasien` e ON e.`NORM` = b.`NORM`
            LEFT JOIN `pendaftaran`.`penjamin` f ON f.`NOPEN` = a.`NOPEN`
            LEFT JOIN (SELECT * FROM `master`.`referensi` WHERE JENIS = 10) g ON g.ID = f.`JENIS`
            LEFT JOIN `berkas_rekammedis`.`terima_berkas` h ON h.`NOPEN` = a.`NOPEN` AND h.`STATUS` = 1
            WHERE a.`STATUS` = 1 AND d.`JENIS_KUNJUNGAN` = 3 
            ".$filter."
            ORDER BY c.`RUANGAN` ASC
            ")->queryAll();
        }
        $excelData = htmlspecialchars(Json::encode($data));
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['noRm','namaPasien','tglPulang','ruangan','caraBayar','tglKembali'],
            ],
        ]);

        return $this->render('pasien-pulang',[
            'dataProvider' => $provider,
            'excelData' => $excelData
        ]);
    }

    public function actionReservasi()
    {
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) = '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) between '".$tglAw."' and '".$tglAk."'";
        }

        $filterRm = "";
        $noRm = Yii::$app->request->get('noRm');
        if($noRm != ""){
            $filterRm = " and b.`NORM` = '".$noRm."'";
        }

        $filterNama = "";
        $namaPasien = Yii::$app->request->get('namaPasien');
        if($namaPasien != ""){
            $filterNama = " and e.`NAMA` like '%".$namaPasien."%'";
        }

        $filterCb = "";
        $caraBayar = Yii::$app->request->get('caraBayar');
        if($caraBayar != ""){
            $filterCb = " and f.`JENIS` = '".$caraBayar."'";
        }

        $filterRuang = "";
        $ruangan = Yii::$app->request->get('ruangan');
        if($ruangan != ""){
            $filterRuang = " and c.`RUANGAN` = '".$ruangan."'";
        }
        $filter = $filterTgl.$filterRm.$filterCb.$filterRuang.$filterNama;
        $data=[];
        if($filter){
            $data = Yii::$app->db_pembayaran->createCommand("
            SELECT 'SurKon' jenisApp,c.`NORM`,d.`NAMA`,DATE(d.`TANGGAL_LAHIR`) tglLahir,e.`NOMOR` noHp
            ,a.`DIBUAT_TANGGAL` createDate,a.`TANGGAL` tglKontrol,a.`TANGGAL` tglReservasi,g.`DESKRIPSI` asal
            ,f.`DESKRIPSI` tujuan,i.`NAMA` namaDokter,a.`NOMOR_BOOKING`,a.`NOMOR_REFERENSI`,j.ICD
            FROM `medicalrecord`.`jadwal_kontrol` a
            LEFT JOIN pendaftaran.`kunjungan` b ON b.`NOMOR` = a.`KUNJUNGAN`
            LEFT JOIN `pendaftaran`.`pendaftaran` c ON c.`NOMOR` = b.`NOPEN`
            LEFT JOIN `master`.`pasien` d ON d.`NORM` = c.`NORM`
            LEFT JOIN `master`.`kontak_pasien` e ON e.`NORM` = c.`NORM` AND e.`JENIS` = 3
            LEFT JOIN `master`.`ruangan` f ON f.`ID` = a.`RUANGAN`
            LEFT JOIN `master`.`ruangan` g ON g.`ID` = b.`RUANGAN`
            LEFT JOIN `master`.`dokter` h ON h.`ID`	 = a.`DOKTER`
            LEFT JOIN `master`.`pegawai` i ON i.`NIP` = h.`NIP`
            LEFT JOIN master.diagnosa_masuk j ON c.DIAGNOSA_MASUK=j.ID
            WHERE a.`STATUS` = 1 AND b.`STATUS` IN (1,2) AND c.`STATUS` IN (1,2)
            AND a.`TANGGAL` = :tgl
            UNION ALL
            SELECT 'MJKN' jenisApp,a.`NORM`,a.`NAMA`,a.`TANGGAL_LAHIR` tglLahir,a.`CONTACT` noHp,a.`TGL_DAFTAR`
            ,d.`tglRencanaKontrol` tglKontrol,a.`TANGGALKUNJUNGAN` tglReservasi,d.`nomor` asal
            , b.`DESKRIPSI` tujuan,c.`nama`,a.`ID`,a.`NO_REF_BPJS`,g.`ICD` icd
            FROM `regonline`.`reservasi` a
            LEFT JOIN `master`.`ruangan` b ON b.`ID` = a.`POLI`
            LEFT JOIN `bpjs`.`dpjp` c ON c.`kode` = a.`DOKTER`
            LEFT JOIN `bpjs`.`rencana_kontrol` d ON d.`noSurat` = a.`NO_REF_BPJS` AND d.`status` = 1
            LEFT JOIN `pendaftaran`.`penjamin` e ON e.`NOMOR` = d.nomor
            LEFT JOIN `pendaftaran`.`pendaftaran` f ON f.`NOMOR` = e.`NOPEN`
            LEFT JOIN master.diagnosa_masuk g ON f.DIAGNOSA_MASUK=g.ID
            WHERE a.`JENIS_APLIKASI` = 2 AND a.`STATUS` != 0
            AND a.`TANGGALKUNJUNGAN` = :tgl
            ")->bindValue(':tgl', $tglAw)
                ->queryAll();
        }
        $excelData = htmlspecialchars(Json::encode($data));
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['jenisApp','NORM','NAMA','tglLahir','noHp','createDate','createDate','tglKontrol'
                    ,'tglReservasi','asal','tujuan','namaDokter','ICD'],
            ],
        ]);

        return $this->render('reservasi',[
            'dataProvider' => $provider,
            'excelData' => $excelData
        ]);
    }

    public function actionPasienRanap()
    {
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " and DATE(k.`MASUK`) = '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " and DATE(k.`MASUK`) between '".$tglAw."' and '".$tglAk."'";
        }

        $filterRm = "";
        $noRm = Yii::$app->request->get('noRm');
        if($noRm != ""){
            $filterRm = " and ps.NORM = '".$noRm."'";
        }

        $filterNama = "";
        $namaPasien = Yii::$app->request->get('namaPasien');
        if($namaPasien != ""){
            $filterNama = " and ps.NAMA like '%".$namaPasien."%'";
        }

        $filterCb = "";
        $caraBayar = Yii::$app->request->get('caraBayar');
        if($caraBayar != ""){
            $filterCb = " and jmn.JENIS = '".$caraBayar."'";
        }

        $filterRuang = "";
        $ruangan = Yii::$app->request->get('ruangan');
        if($ruangan != ""){
            $filterRuang = " and rk.RUANGAN = '".$ruangan."'";
        }

        $filterAlamat = "";
        $alamat = Yii::$app->request->get('alamat');
        if($alamat != ""){
            $filterAlamat = " and ps.`ALAMAT` like '%".$alamat."%'";
        }

        $filterNs = "";
        $isSep = Yii::$app->request->get('isSep');
        if($isSep != ""){
            $filterNs = " and (jmn.`NOMOR` = '' or jmn.`NOMOR` is null)";
        }

        $filter = $filterTgl.$filterRm.$filterCb.$filterRuang.$filterNama.$filterNs.$filterAlamat;
        $data = Yii::$app->db_pembayaran->createCommand("
            SELECT ps.NORM,ps.NAMA, ps.`ALAMAT`,k.`MASUK`,rgn.DESKRIPSI RUANGAN,rkt.TEMPAT_TIDUR,rf.`DESKRIPSI` caraBayar
                 ,jmn.`NOMOR` noSep
            FROM master.ruang_kamar_tidur rkt
            LEFT JOIN pendaftaran.kunjungan k ON k.RUANG_KAMAR_TIDUR = rkt.ID AND k.STATUS = 1
            LEFT JOIN pendaftaran.pendaftaran p ON p.NOMOR = k.NOPEN
            LEFT JOIN master.pasien ps ON ps.NORM = p.NORM  
            LEFT JOIN master.ruang_kamar rk ON rk.ID = rkt.RUANG_KAMAR
            LEFT JOIN master.ruangan rgn ON rgn.ID = rk.RUANGAN
            LEFT JOIN `pendaftaran`.`penjamin` jmn ON jmn.`NOPEN` = p.`NOMOR`
            LEFT JOIN master.referensi rf ON rf.JENIS = 10 AND jmn.JENIS = rf.ID
            WHERE rkt.`STATUS` = 3
            AND pendaftaran.ikutRawatInapIbu(k.NOPEN, k.REF) = 0
            AND k.KELUAR IS NULL
            ".$filter."
            ORDER BY rkt.`ID` ASC
            ")->queryAll();
        $excelData = htmlspecialchars(Json::encode($data));
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['NORM','RUANGAN','noSep','caraBayar'],
            ],
        ]);

        return $this->render('pasien-ranap',[
            'dataProvider' => $provider,
            'excelData' => $excelData
        ]);
    }

    public function actionReservasiSurkon()
    {
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) = '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) between '".$tglAw."' and '".$tglAk."'";
        }

        $filterRm = "";
        $noRm = Yii::$app->request->get('noRm');
        if($noRm != ""){
            $filterRm = " and c.`NORM` = '".$noRm."'";
        }

        $filterNama = "";
        $namaPasien = Yii::$app->request->get('namaPasien');
        if($namaPasien != ""){
            $filterNama = " and d.`NAMA` like '%".$namaPasien."%'";
        }

        $filterRuang = "";
        $ruangan = Yii::$app->request->get('ruangan');
        if($ruangan != ""){
            $filterRuang = " and a.`RUANGAN` = '".$ruangan."'";
        }

        $filterDokter = "";
        $dokter = Yii::$app->request->get('dokter');
        if($dokter != ""){
            $filterDokter = " and h.NIP = '".$dokter."'";
        }
        $filter = $filterTgl.$filterRm.$filterRuang.$filterNama.$filterDokter;
        $data=[];
        if($filter){
            $data = Yii::$app->db_pembayaran->createCommand("
            SELECT c.`NORM` noRm,d.`NAMA` namaPasien,DATE(d.`TANGGAL_LAHIR`) tglLahir,e.`NOMOR` noHp
            ,a.`DIBUAT_TANGGAL` createDate,a.`TANGGAL` tglKontrol,g.`DESKRIPSI` asal
            ,f.`DESKRIPSI` tujuan,i.`NAMA` namaDokter,a.`NOMOR_BOOKING`,a.`NOMOR_REFERENSI`,j.ICD
            ,l.`DESKRIPSI` jaminan,CONCAT(DATE_FORMAT(a.`TANGGAL`,'%Y'), a.`NOMOR`) noSurkon
            FROM `medicalrecord`.`jadwal_kontrol` a
            LEFT JOIN pendaftaran.`kunjungan` b ON b.`NOMOR` = a.`KUNJUNGAN`
            LEFT JOIN `pendaftaran`.`pendaftaran` c ON c.`NOMOR` = b.`NOPEN`
            LEFT JOIN `master`.`pasien` d ON d.`NORM` = c.`NORM`
            LEFT JOIN `master`.`kontak_pasien` e ON e.`NORM` = c.`NORM` AND e.`JENIS` = 3
            LEFT JOIN `master`.`ruangan` f ON f.`ID` = a.`RUANGAN`
            LEFT JOIN `master`.`ruangan` g ON g.`ID` = b.`RUANGAN`
            LEFT JOIN `master`.`dokter` h ON h.`ID`	 = a.`DOKTER`
            LEFT JOIN `master`.`pegawai` i ON i.`NIP` = h.`NIP`
            LEFT JOIN master.diagnosa_masuk j ON c.DIAGNOSA_MASUK=j.ID
            LEFT JOIN `pendaftaran`.`penjamin` k ON k.`NOPEN` = b.`NOPEN`
            LEFT JOIN `master`.`referensi` l ON l.`ID` = k.`JENIS` AND l.`JENIS` = 10            
            WHERE a.`STATUS` = 1 AND b.`STATUS` IN (1,2) AND c.`STATUS` IN (1,2)
            ".$filter."
            ")->queryAll();
        }
        $excelData = htmlspecialchars(Json::encode($data));
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['noRm','namaPasien','tglLahir','noHp','createDate','createDate','tglKontrol'
                    ,'asal','tujuan','namaDokter','ICD','noSurkon','NOMOR_BOOKING','NOMOR_REFERENSI'],
            ],
        ]);

        return $this->render('reservasi-surkon',[
            'dataProvider' => $provider,
            'excelData' => $excelData
        ]);
    }

    public function actionReservasiMjkn()
    {
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " and DATE(a.`TANGGALKUNJUNGAN`) = '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " and DATE(a.`TANGGALKUNJUNGAN`) between '".$tglAw."' and '".$tglAk."'";
        }

        $filterRm = "";
        $noRm = Yii::$app->request->get('noRm');
        if($noRm != ""){
            $filterRm = " and a.`NORM` = '".$noRm."'";
        }

        $filterNama = "";
        $namaPasien = Yii::$app->request->get('namaPasien');
        if($namaPasien != ""){
            $filterNama = " and a.`NAMA` like '%".$namaPasien."%'";
        }

        $filterRuang = "";
        $ruangan = Yii::$app->request->get('ruangan');
        if($ruangan != ""){
            $filterRuang = " and a.POLI = '".$ruangan."'";
        }

        $filterDokter = "";
        $dokter = Yii::$app->request->get('dokter');
        if($dokter != ""){
            $filterDokter = " and a.`DOKTER` = '".$dokter."'";
        }
        $filter = $filterTgl.$filterRm.$filterRuang.$filterNama.$filterDokter;
        $data=[];
        if($filter){
            $data = Yii::$app->db_pembayaran->createCommand("
            SELECT a.`NORM` noRm,a.`NAMA` namaPasien,a.`TANGGAL_LAHIR` tglLahir,a.`CONTACT` noHp,a.`TGL_DAFTAR` createDate
            ,d.`tglRencanaKontrol` tglKontrol,a.`TANGGALKUNJUNGAN` tglReservasi
            , b.`DESKRIPSI` tujuan,c.`nama` namaDokter,a.`ID` noBooking,a.`NO_REF_BPJS` noRef,e.`diagAwal` icd
            FROM `regonline`.`reservasi` a
            LEFT JOIN `master`.`ruangan` b ON b.`ID` = a.`POLI`
            LEFT JOIN `bpjs`.`dpjp` c ON c.`kode` = a.`DOKTER`
            LEFT JOIN `bpjs`.`rencana_kontrol` d ON d.`noSurat` = a.`NO_REF_BPJS` AND d.`status` = 1
            LEFT JOIN `bpjs`.`kunjungan` e ON e.`noSEP` = d.`nomor`
            WHERE a.`JENIS_APLIKASI` = 2 AND a.`STATUS` != 0
            ".$filter."
            ")->queryAll();
        }
        $excelData = htmlspecialchars(Json::encode($data));
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['noRm','namaPasien','tglLahir','noHp','createDate','tglKontrol'
                    ,'tglReservasi','tujuan','namaDokter','ICD'],
            ],
        ]);

        return $this->render('reservasi-mjkn',[
            'dataProvider' => $provider,
            'excelData' => $excelData
        ]);
    }

    public function actionPasien()
    {
        $filterNorm = "";
        $noRm= Yii::$app->request->get('noRm');
        if($noRm != ""){
            $filterNorm = " a.NORM = ".$noRm;
        }
        $filter = $filterNorm;

        $filterNama = "";
        $namaPasien = Yii::$app->request->get('namaPasien');
        if($namaPasien != ""){
            $filterNama = "a.`NAMA` like '%".$namaPasien."%'";
            $filterNama = $filter ? " and ".$filterNama : $filterNama;
        }
        $filter = $filter.$filterNama;

        $filterAlamat = "";
        $alamat = Yii::$app->request->get('alamat');
        if($alamat != ""){
            $filterAlamat = "a.`ALAMAT` like '%".$alamat."%'";
            $filterAlamat = $filter ? " and ".$filterAlamat : $filterAlamat;
        }
        $filter = $filter.$filterAlamat;

        $filterKtp = "";
        $noKtp = Yii::$app->request->get('noKtp');
        if($noKtp != ""){
            $filterKtp = "b.`NOMOR` = '".$noKtp."'";
            $filterKtp = $filter ? " and ".$filterKtp : $filterKtp;
        }
        $filter = $filter.$filterKtp;

        $filterHp = "";
        $noHp = Yii::$app->request->get('noHp');
        if($noHp != ""){
            $filterHp = "c.`NOMOR` = '".$noHp."'";
            $filterHp = $filter ? " and ".$filterHp : $filterHp;
        }
        $filter = $filter.$filterHp;

        $filterBpjs = "";
        $noBpjs = Yii::$app->request->get('noBpjs');
        if($noBpjs != ""){
            $filterBpjs = "d.`NOMOR` = '".$noBpjs."'";
            $filterBpjs = $filter ? " and ".$filterBpjs : $filterBpjs;
        }
        $filter = $filter.$filterBpjs;

        $data=[];
        if($filter){
            $data = Yii::$app->db_pembayaran->createCommand("
            SELECT a.`NORM`,a.`TANGGAL` tglBuat,a.`NAMA`,DATE(a.`TANGGAL_LAHIR`) tglLahir
            ,IF(a.`JENIS_KELAMIN` = 1,'L','P') jnsKelamin,a.`ALAMAT`,b.`NOMOR` noKtp,c.`NOMOR` noHp,d.`NOMOR` noBpjs
            FROM `master`.`pasien` a
            LEFT JOIN `master`.`kartu_identitas_pasien` b ON b.`NORM` = a.`NORM`
            LEFT JOIN `master`.`kontak_pasien` c ON c.`NORM` = a.`NORM` AND c.`JENIS` = 3
            LEFT JOIN `master`.`kartu_asuransi_pasien` d ON d.`NORM` = a.`NORM` AND d.`JENIS` = 2
            WHERE ".$filter."
            ")->queryAll();
        }
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['NORM','tglBuat','NAMA','tglLahir','ALAMAT','jnsKelamin','noKtp','noHp','noBpjs'],
            ],
        ]);

        return $this->render('pasien',[
            'dataProvider' => $provider,
        ]);
    }

    public function actionRujukanBpjs($noBpjs,$type="Pcare"){
        $dataRujukan = $type == "Pcare" ? $this->sendReqBpjs("Rujukan/List/Peserta/".$noBpjs."","GET") :
            $this->sendReqBpjs("Rujukan/RS/List/Peserta/".$noBpjs."","GET");
        /*echo "<pre>";
        print_r($dataRujukan);
        exit;*/
        $dataTable = [];
        $message = $dataRujukan['metaData']['message'];
        if($dataRujukan['metaData']['code'] == '200' && $dataRujukan['response']['rujukan'] != ""){
            if(count($dataRujukan['response']['rujukan']) > 0){
                foreach ($dataRujukan['response']['rujukan'] as $item){
                    $date = date_create($item['tglKunjungan']);
                    date_add($date,date_interval_create_from_date_string("89 days"));
                    $date = date_format($date,"Y-m-d");
                    $dataTable[] = [
                        'noKunjungan' =>  $item['noKunjungan'],
                        'tglKunjungan' =>  $item['tglKunjungan'],
                        'tglHabisKunjungan' => $date,
                        'diagnosa' =>  $item['diagnosa']['kode']." - ".$item['diagnosa']['nama'],
                        'poliRujukan' =>  $item['poliRujukan']['nama'],
                        'provPerujuk' =>  $item['provPerujuk']['nama'],
                    ];
                }
            }
        }

        $provider = new ArrayDataProvider([
            'allModels' => $dataTable,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['noKunjungan','tglHabisKunjungan','tglKunjungan','diagnosa','poliRujukan','provPerujuk'],
            ],
        ]);

        return $this->renderAjax('rujukan-bpjs',[
            'dataProvider' => $provider,
            'message' => $message
        ]);
    }

    public function actionSurkonBpjs($noBpjs,$type){
        $url = "RencanaKontrol/ListRencanaKontrol/Bulan/".date('m')."/Tahun/".date('Y')."/Nokartu/".$noBpjs."/filter/".$type;
        $dataSurkon = $this->sendReqBpjs($url,"GET");
        /*echo "<pre>";
        print_r($dataSurkon);
        exit;*/
        $dataTable = [];
        $message = $dataSurkon['metaData']['message'];
        if($dataSurkon['metaData']['code'] == '200' && $dataSurkon['response']['list'] != ""){
            if(count($dataSurkon['response']['list']) > 0){
                foreach ($dataSurkon['response']['list'] as $item){
                    $dataTable[] = [
                        'noSuratKontrol' =>  $item['noSuratKontrol'],
                        'jnsPelayanan' =>  $item['jnsPelayanan'],
                        'tglRencanaKontrol' => $item['tglRencanaKontrol'],
                        'tglTerbitKontrol' =>  $item['tglTerbitKontrol'],
                        'noSepAsalKontrol' =>  $item['noSepAsalKontrol'],
                        'namaPoliTujuan' =>  $item['namaPoliTujuan'],
                        'namaDokter' => $item['namaDokter'],
                        'terbitSEP' => $item['terbitSEP'],
                    ];
                }
            }
        }

        $provider = new ArrayDataProvider([
            'allModels' => $dataTable,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['noSuratKontrol','jnsPelayanan','tglRencanaKontrol','tglTerbitKontrol'
                    ,'noSepAsalKontrol','namaPoliTujuan','namaDokter','terbitSEP'],
            ],
        ]);

        return $this->renderAjax('kontrol-bpjs',[
            'dataProvider' => $provider,
            'message' => $message,
            'type' => $type
        ]);
    }

    public function actionHistoriSep($noBpjs){
        $url = "monitoring/HistoriPelayanan/NoKartu/".$noBpjs."/tglMulai/".date('Y-m-d',strtotime("-2 month"))."/tglAkhir/".date('Y-m-d');
        $dataSep = $this->sendReqBpjs($url,"GET");
        /*echo "<pre>";
        print_r($dataSep);
        exit;*/
        $dataTable = [];
        $message = $dataSep['metaData']['message'];
        if($dataSep['metaData']['code'] == '200' && $dataSep['response']['histori'] != ""){
            if(count($dataSep['response']['histori']) > 0){
                foreach ($dataSep['response']['histori'] as $item){
                    $jnsPelayanan = $item['jnsPelayanan'] == '2' ? $item['poli'] : 'Ranap';
                    $dataTable[] = [
                        'noSep' =>  $item['noSep'],
                        'tglSep' =>  $item['tglSep'],
                        'jnsPelayanan' => $jnsPelayanan,
                        'diagnosa' =>  $item['diagnosa'],
                        'ppkPelayanan' =>  $item['ppkPelayanan'],
                        'noRujukan' => $item['noRujukan'],
                    ];
                }
            }
        }

        $provider = new ArrayDataProvider([
            'allModels' => $dataTable,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['noSep','tglSep','jnsPelayanan','diagnosa','ppkPelayanan','noRujukan'],
            ],
        ]);

        return $this->renderAjax('histori-sep',[
            'dataProvider' => $provider,
            'message' => $message
        ]);
    }

    public function actionToexcel()
    {
        $excelData = Json::decode(Yii::$app->request->post('excelData'));
        $namaFile = Yii::$app->request->post('namaFile').".xls";
        $header = Json::decode(Yii::$app->request->post('header'));

        $file = Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [
                $namaFile => [   // Name of the excel sheet
                    'data' => $excelData,

                    // Set to `false` to suppress the title row
                    'titles' => $header,

                    'formats' => [
                        // Either column name or 0-based column index can be used
                        //'C' => '#,##0.00',
                        //3 => 'dd/mm/yyyy hh:mm:ss',
                    ],

                    'formatters' => [
                        // Dates and datetimes must be converted to Excel format
                        //3 => function ($value, $row, $data) {
                        //    return \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($value));
                        //},
                    ],
                ],
            ]
        ]);
        // Save on disk
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$namaFile.'"');
        header('Cache-Control: max-age=0');
        $file->saveAs('php://output');
        exit;
    }

    // function decrypt
    function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';

        // hash
        $key_hash = hex2bin(hash('sha256', $key));

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        return $output;
    }

    // function lzstring decompress https://github.com/nullpunkt/lz-string-php
    function decompress($string)
    {
        return LZString::decompressFromEncodedURIComponent($string);
    }

    public function sendReqBpjs($url,$method){
        $consId = "9921";
        $secretKey = "0hFA4C2062";
        $baseUrl = "https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/";
        $userKey = "30ad818f72d295a3d1242a004376aac8";

        date_default_timezone_set('UTC');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $signature = hash_hmac('sha256', $consId . "&" . $tStamp, $secretKey, true);
        $encodedSignature = base64_encode($signature);

        $url = $baseUrl.$url;
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod($method)
            ->setUrl($url)
            ->addHeaders([
                'X-cons-id' => $consId,
                'X-timestamp' => $tStamp,
                'X-signature' => $encodedSignature,
                'Content-Type' => 'application/json',
                'user_key' => $userKey
            ])
            ->send();
        if ($response->isOk) {
            $data = $response->data;
            if ($data['metaData']['code'] == "200") {
                $keyEncrypt = $consId . $secretKey . $tStamp;
                $decr = $this->stringDecrypt($keyEncrypt, $data['response']);
                $deco = $this->decompress($decr);
                return [
                    'metaData' => [
                        'code' => "200",
                        'message' => "OK"
                    ],
                    'response' => Json::decode($deco)
                ];
            }
            return $data;
        }

        return [
            'metaData' => [
                'code' => "500",
                'message' => "Respon Error"
            ]
        ];
    }
}
