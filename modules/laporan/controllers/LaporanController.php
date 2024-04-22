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
