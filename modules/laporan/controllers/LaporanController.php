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

        $filter = $filterTgl.$filterRm.$filterCb.$filterRuang.$filterDokter.$filterNs.$filterNama;
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

    public function actionToexcel()
    {
        $excelData = Json::decode(Yii::$app->request->post('excelData'));
        $namaFile = Yii::$app->request->post('namaFile');
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
