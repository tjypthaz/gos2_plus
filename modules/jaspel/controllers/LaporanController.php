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
                "SELECT CONCAT(LPAD(a.`bulan`,2,'0'),'-',a.`tahun`) periode,b.`ruangan`,a.`caraBayar`
            -- ,b.`idDokterO`,b.`idDokterL`,b.`idPara`
            ,b.`namaDokterO`,b.`namaDokterL`,b.`jenisPara`
            ,SUM(b.`jpDokterO`) jpDokterO,SUM(b.`jpDokterL`) jpDokterL,SUM(b.`jpPara`) jpPara
            ,SUM(b.`jpStruktural`) jpStruktural,SUM(b.`jpBlud`) jpBlud,SUM(b.`jpPegawai`) jpPegawai
            FROM `jaspel_cokro`.`jaspel` a
            LEFT JOIN `jaspel_cokro`.`jaspel_final` b ON b.`idJaspel` = a.`id`
            WHERE a.`publish` = 1 AND b.`id` IS NOT NULL
            AND a.`bulan` = ".$bulan."
            AND a.`tahun` = ".$tahun."
            GROUP BY a.`idCaraBayar`,b.`idRuangan`,b.`idDokterO`,b.`idDokterL`,b.`idPara`"
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

    public function actionToexcel()
    {
        $excelData = Json::decode(Yii::$app->request->post('excelData'));

        $file = Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [
                'Rekap Jaspel' => [   // Name of the excel sheet
                    'data' => $excelData,

                    // Set to `false` to suppress the title row
                    'titles' => [
                        'Periode',
                        'Unit',
                        'Cara Bayar',
                        'Dokter Operator',
                        'Dokter Lainnya',
                        'Jenis Paramedis',
                        'Jp Dokter Operator',
                        'Jp Dokter Lainnya',
                        'Jp Paramedis',
                        'Jp Struktural',
                        'Jp Blud',
                        'Jp Pegawai',
                    ],

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
        header('Content-Disposition: attachment;filename="download"');
        header('Cache-Control: max-age=0');
        $file->saveAs('php://output');
        exit;
    }

}
