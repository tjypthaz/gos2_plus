<?php

namespace app\modules\laporan\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
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

        $filter = $filterTgl.$filterRm.$filterCb.$filterRuang.$filterDokter.$filterNs.$filterNama.$filterjenis;
        $data=[];
        if($filter){
            $data = Yii::$app->db_pembayaran->createCommand("
            SELECT a.`NOMOR` idReg,a.`NORM` noRm,b.`NAMA` namaPasien,DATE(a.`TANGGAL`) tglDaftar,d.`DESKRIPSI` tujuan
            ,f.`NAMA` dokter,h.`DESKRIPSI` caraBayar,g.`NOMOR` noSep
            ,if(c.`STATUS` = '1', 'Belum','Sudah') diTerima
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
                'attributes' => ['noRm','namaPasien','tglDaftar','tujuan','dokter','caraBayar','diTerima'],
            ],
        ]);

        return $this->render('detail-pengunjung',[
            'dataProvider' => $provider,
            'excelData' => $excelData
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
        $filterNs = "";
        $isSep = Yii::$app->request->get('isSep');
        if($isSep != ""){
            $filterNs = " and (jmn.`NOMOR` = '' or jmn.`NOMOR` is null)";
        }

        $filter = $filterTgl.$filterRm.$filterCb.$filterRuang.$filterNama.$filterNs;
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
}
