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
        /*$arrPData = [
            'request' => [
                't_sep' => [
                    'noKartu' => '0000075026946',
                    'tglSep' => date('Y-m-d'),
                    'jnsPelayanan' => '2',
                    'jnsPengajuan' => '2',
                    'keterangan' => 'Coba coba',
                    'user' => Yii::$app->user->identity->username,
                ]
            ]
        ];

        $data = BridBpjs::vclaim(
            "Sep/pengajuanSEP",
            "POST",
             "application/x-www-form-urlencoded", //"application/json",
            Json::encode($arrPData)
        );
        echo "<pre>";
        print_r($data);
        exit;*/


        return $this->render('index',[
            //'dataProvider' => $provider,
        ]);
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
}
