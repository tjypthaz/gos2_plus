<?php

namespace app\modules\antrian\controllers;

use app\models\BridBpjs;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `fingerprint` module
 */
class FingerprintController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCekPeserta($nomor){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $url = strlen($nomor) == 13 ?
            "Peserta/nokartu/".$nomor."/tglSEP/".date('Y-m-d') :
            "Peserta/nik/".$nomor."/tglSEP/".date('Y-m-d');
        $data = BridBpjs::vclaim(
            $url,
            "GET",
            "application/json" //"application/x-www-form-urlencoded",
        );

        return $data;
    }

    public function actionCekFinger($nomor){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = BridBpjs::vclaim(
            "SEP/FingerPrint/Peserta/".$nomor."/TglPelayanan/".date('Y-m-d'),
            "GET",
            "application/json" //"application/x-www-form-urlencoded",
        );

        return $data;
    }

    public function actionPengajuan($nomor)
    {
        if(Yii::$app->request->isPost){
            $arrPData = [
                'request' => [
                    't_sep' => [
                        'noKartu' => Yii::$app->request->post('nomor'),
                        'tglSep' => date('Y-m-d'),
                        'jnsPelayanan' => '2',
                        'jnsPengajuan' => '2',
                        'keterangan' => Yii::$app->request->post('alasan'),
                        'user' => Yii::$app->user->identity->username,
                    ]
                ]
            ];

            $pengajuan = BridBpjs::vclaim(
                "Sep/pengajuanSEP",
                "POST",
                "application/x-www-form-urlencoded",
                Json::encode($arrPData)
            );
            /*echo "<pre>";
            print_r($pengajuan);
            exit;*/
            if ($pengajuan['metaData']['code'] == "200") {
                $approval = BridBpjs::vclaim(
                    "Sep/aprovalSEP",
                    "POST",
                    "application/x-www-form-urlencoded",
                    Json::encode($arrPData)
                );
                if ($approval['metaData']['code'] == "200") {
                    Yii::$app->session->setFlash('success','Berhasil Pengajuan');
                }
                else{
                    Yii::$app->session->setFlash('error',$pengajuan['metaData']['message']);
                }
            }
            else{
                Yii::$app->session->setFlash('error',$pengajuan['metaData']['message']);
            }

            return $this->redirect(['index','nomor' => $nomor]);
        }
        return $this->renderAjax('pengajuan',[
            'nomor' => $nomor
        ]);
    }
}
