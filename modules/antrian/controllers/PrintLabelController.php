<?php

namespace app\modules\antrian\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\web\Controller;

/**
 * Default controller for the `laporan` module
 */
class PrintLabelController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        // find data and send to print
        $nOpen = Yii::$app->db_pembayaran->createCommand("
        SELECT id,nOpen,norm FROM `pendaftaran`.`apm_auto_print` 
        WHERE STATUS = 1 and date(create_date) = curdate()
        ORDER BY id ASC
        LIMIT 1
        ")->queryOne();
        if($nOpen['nOpen']){
            try {
                $client = new Client();
                $url = "http://".Yii::$app->request->userIP.":8989/label/".$nOpen['nOpen']."/5";
                $response = $client->createRequest()
                    ->setMethod('GET')
                    ->setUrl($url)
                    ->setOptions([
                        'timeout' => 3, // set timeout to 5 seconds for the case server is not responding
                    ])
                    ->send();
                if ($response->isOk) {
                    $resData = $response->data;
                    if($resData['status'] == 'success'){
                           Yii::$app->db_pembayaran->createCommand("
                           update `pendaftaran`.`apm_auto_print` set status = 2, update_date = now() where nOpen = :nOpen 
                           ")->bindValue(':nOpen',$nOpen['nOpen'])->execute();
                           $message = "Kirim Print NOPEN : ".$nOpen['nOpen'];
                           Yii::$app->session->setFlash('success',$message);
                    }
                }
            }
            catch (\Throwable $e){
                Yii::$app->session->setFlash('error',"Aplikasi Print Direct Tidak Aktif");
            }
        }else if($nOpen['norm']){
            $idReg = Yii::$app->db_pembayaran->createCommand("
            SELECT c.NOMOR 
            FROM `pendaftaran`.`pendaftaran` c 
            WHERE c.`NORM` = :norm AND DATE(c.`TANGGAL`) = curdate();
            ")->bindValue(':norm',$nOpen['norm'])->queryScalar();
            Yii::$app->db_pembayaran->createCommand("
            update `pendaftaran`.`apm_auto_print`
            set nOpen = :idReg
            where id = :id
            ")->bindValues([
                ':idReg' => $idReg,
                ':id' => $nOpen['id']
            ])->execute();
        }
        $data = Yii::$app->db_pembayaran->createCommand("
        SELECT a.`nOpen`,b.`NORM`,c.`NAMA`,a.`create_date`,a.`status` statusPrint
        FROM `pendaftaran`.`apm_auto_print` a
        LEFT JOIN `pendaftaran`.`pendaftaran` b ON b.`NOMOR` = a.`nOpen`
        LEFT JOIN `master`.`pasien` c ON c.`NORM` = b.`NORM`
        WHERE a.`status` = 1 and date(a.`create_date`) = curdate()
        order by a.id asc
        ")->queryAll();
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['nOpen','NORM','NAMA','create_date','statusPrint'],
            ],
        ]);

        return $this->render('index',[
            'dataProvider' => $provider,
        ]);
    }
}
