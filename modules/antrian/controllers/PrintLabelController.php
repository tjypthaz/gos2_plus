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
        SELECT nOpen FROM `pendaftaran`.`apm_auto_print` 
        WHERE STATUS = 1 and date(create_date) = curdate()
        ORDER BY id ASC
        LIMIT 1
        ")->queryScalar();
        if($nOpen){
            try {
                $client = new Client();
                $url = "http://".Yii::$app->request->userIP.":8989/label/".$nOpen."/1";
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
                           ")->bindValue(':nOpen',$nOpen)->execute();
                           $message = "Kirim Print NOPEN : ".$nOpen;
                           Yii::$app->session->setFlash('success',$message);
                    }
                }
            }
            catch (\Throwable $e){
                Yii::$app->session->setFlash('error',"Aplikasi Print Direct Tidak Aktif");
            }
        }
        $data = Yii::$app->db_pembayaran->createCommand("
        SELECT a.`nOpen`,b.`NORM`,c.`NAMA`,a.`create_date`,a.`status` statusPrint
        FROM `pendaftaran`.`apm_auto_print` a
        LEFT JOIN `pendaftaran`.`pendaftaran` b ON b.`NOMOR` = a.`nOpen`
        LEFT JOIN `master`.`pasien` c ON c.`NORM` = b.`NORM`
        order by a.id desc
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
