<?php

namespace app\modules\jaspel\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class LaporanController extends \yii\web\Controller
{
    public function actionIndex($bulan=null,$tahun=null)
    {
        $data = [];
        if($bulan && $tahun){
            $data = Yii::$app->db_jaspel->createCommand(
                "
            select * from (
            SELECT CONCAT(LPAD(a.`bulan`,2,'0'),'-',a.`tahun`) periode,b.`ruangan`,a.`caraBayar`
            ,b.`namaDokterO`,b.`namaDokterL`,b.`jenisPara`
            ,SUM(b.`jpDokterO`) jpDokterO,SUM(b.`jpDokterL`) jpDokterL,SUM(b.`jpPara`) jpPara
            ,SUM(b.`jpAkomodasi`) jpAkomodasi,SUM(b.`jpStruktural`) jpStruktural,SUM(b.`jpBlud`) jpBlud
            ,SUM(b.`jpPegawai`) jpPegawai
            ,b.`idDokterO`,b.`idDokterL`,b.`idPara`,b.`idRuangan`,a.`idCaraBayar`,a.`bulan`,a.`tahun`
            FROM `jaspel_cokro`.`jaspel` a
            LEFT JOIN `jaspel_cokro`.`jaspel_final` b ON b.`idJaspel` = a.`id`
            WHERE a.`publish` = 1 AND b.`id` IS NOT NULL
            AND a.`bulan` = ".$bulan."
            AND a.`tahun` = ".$tahun."
            GROUP BY a.`idCaraBayar`,b.`idRuangan`,b.`idDokterO`,b.`idDokterL`,b.`idPara`    
            ) a order by namaDokterO
            "
            )->queryAll();
        }
        $excelData = htmlspecialchars(Json::encode($data));
        //echo $excel;exit;

        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['ruangan','namaDokterO','namaDokterL','jenisPara'],
            ],
        ]);

        $listDokter = Yii::$app->db_jaspel
            ->createCommand("SELECT a.`ID`,b.`NAMA`
            FROM master.`dokter` a
            LEFT JOIN master.`pegawai` b ON b.`NIP` = a.`NIP`
            WHERE a.`STATUS` = 1 ORDER BY b.`NAMA` ASC")
            ->queryAll();
        $listDokter = ArrayHelper::map($listDokter,'ID','NAMA');

        $listJenisPara = Yii::$app->db_jaspel
            ->createCommand("SELECT a.`ID`,a.`DESKRIPSI`
            FROM master.`referensi` a
            WHERE a.`JENIS` = 32 AND a.`STATUS` = 1 and a.id not in (1,2)")
            ->queryAll();
        $listJenisPara = ArrayHelper::map($listJenisPara,'ID','DESKRIPSI');

        return $this->render('index',[
            'dataProvider' => $provider,
            'listDokter' => $listDokter,
            'listJenisPara' => $listJenisPara,
            'excelData' => $excelData,
        ]);
    }

    public function actionDetail($bulan=null,$tahun=null,$idDokter=null,$idCaraBayar=null,$idRuangan=null,$idPara=null)
    {
        $data = [];
        $idPara = $idPara ? " AND b.`idPara` = ".$idPara : " AND (b.`idPara` = 0 or b.`idPara` is null)";
        $idDokter = $idDokter ? " AND (b.`idDokterO` = ".$idDokter." OR b.`idDokterL` = ".$idDokter.")" : " AND b.`idDokterO` = 0";
        if($bulan && $tahun && $idDokter && $idCaraBayar && $idRuangan){
            $data = Yii::$app->db_jaspel->createCommand(
                "SELECT b.id,CONCAT(LPAD(a.`bulan`,2,'0'),'-',a.`tahun`) periode,a.`tgl` tglDaftar,a.`noRm`,a.`namaPasien`
            ,b.`ruangan`,a.`caraBayar`,b.`namaDokterO`,b.`namaDokterL`,b.`jenisPara`,b.`tindakan`,b.`jpDokterO`,b.`jpDokterL`,b.`jpPara`
            ,b.`jpAkomodasi`
            FROM `jaspel_cokro`.`jaspel` a
            LEFT JOIN `jaspel_cokro`.`jaspel_final` b ON b.`idJaspel` = a.`id`
            WHERE a.`publish` = 1 AND b.`id` IS NOT NULL
            AND a.`bulan` = ".$bulan." AND a.`tahun` = ".$tahun."
            AND a.`idCaraBayar` = ".$idCaraBayar."
            ".$idDokter."
            ".$idPara."
            AND b.`idRuangan` = '".$idRuangan."'"
            )->queryAll();

        }
        $excelData = htmlspecialchars(Json::encode($data));

        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['ruangan','namaDokterO','namaDokterL','jenisPara','tindakan'],
            ],
        ]);

        $listDokter = Yii::$app->db_jaspel
            ->createCommand("SELECT a.`ID`,b.`NAMA`
            FROM master.`dokter` a
            LEFT JOIN master.`pegawai` b ON b.`NIP` = a.`NIP`
            WHERE a.`STATUS` = 1 ORDER BY b.`NAMA` ASC")
            ->queryAll();
        $listDokter = ArrayHelper::map($listDokter,'ID','NAMA');

        $listJenisPara = Yii::$app->db_jaspel
            ->createCommand("SELECT a.`ID`,a.`DESKRIPSI`
            FROM master.`referensi` a
            WHERE a.`JENIS` = 32 AND a.`STATUS` = 1 and a.id not in (1,2)")
            ->queryAll();
        $listJenisPara = ArrayHelper::map($listJenisPara,'ID','DESKRIPSI');

        $listRuangan = Yii::$app->db_jaspel
            ->createCommand("SELECT a.`ID`,a.`DESKRIPSI`
            FROM master.`ruangan` a
            WHERE a.`STATUS` = 1 AND a.`JENIS` = 5")
            ->queryAll();
        $listRuangan = ArrayHelper::map($listRuangan,'ID','DESKRIPSI');

        $listCarabayar = Yii::$app->db_jaspel
            ->createCommand("SELECT * FROM `master`.`referensi` WHERE JENIS=10 AND `STATUS` = 1")
            ->queryAll();
        $listCarabayar = ArrayHelper::map($listCarabayar,'ID','DESKRIPSI');

        return $this->render('detail',[
            'dataProvider' => $provider,
            'listDokter' => $listDokter,
            'listRuangan' => $listRuangan,
            'listCarabayar' => $listCarabayar,
            'excelData' => $excelData,
            'listJenisPara' => $listJenisPara,
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

    public function actionAmbulan($tglAw=null,$tglAk=null)
    {
        $data = [];
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " AND a.`tanggal` BETWEEN '".$tglAw."' AND '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " AND a.`tanggal` BETWEEN '".$tglAw."' AND '".$tglAk."'";
        }

        $filter = $filterTgl;
        if($tglAw){
            $data = Yii::$app->db_jaspel->createCommand(
                "SELECT b.`NAMA` namaPegawai,SUM(ROUND((a.jpl/a.pembagi),2)) jpl,SUM(ROUND((a.jptl/a.pembagi),2)) jptl
                FROM (
                    SELECT a.`namaPasien`,(a.`jasaPelayanan`*0.6) jpl,(a.`jasaPelayanan`*0.4) jptl,b.`idPegawai`, `pembayaran_cokro`.getJumPetugas(a.`id`) pembagi
                    FROM `pembayaran_cokro`.`tagihan_ambulan` a
                    LEFT JOIN `pembayaran_cokro`.`petugas_ambulan` b ON b.`idTagihanAmbulan` = a.`id`
                    WHERE a.`status` = 2 AND a.`publish` = 1 AND b.`publish` = 1 ".$filter."
                )a
                LEFT JOIN `master`.`pegawai` b ON b.`ID` = a.idPegawai
                GROUP BY a.idPegawai"
            )->queryAll();
        }
        $excelData = htmlspecialchars(Json::encode($data));

        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [],
            ],
        ]);

        return $this->render('ambulan',[
            'dataProvider' => $provider,
            'excelData' => $excelData
        ]);
    }

}
