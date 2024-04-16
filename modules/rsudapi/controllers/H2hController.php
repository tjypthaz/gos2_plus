<?php

namespace app\modules\rsudapi\controllers;

use app\modules\pembayaran\models\H2h;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

/**
 * Default controller for the `rsudapi` module
 */
class H2hController extends Controller
{
    protected function verbs()
    {
        return [
            'get-tagihan' => ['GET'],
            'bayar-tagihan' => ['POST'],
            'reversal' => ['POST'],
        ];
    }

    public function behaviors()
    {
        $behavior = parent::behaviors();

        $behavior['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];

        return $behavior;
    }

    public function actionGetTagihan()
    {
        // jangan lupa create log request
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = false;
        $idTagihan = Yii::$app->request->get('idTagihan');
        if($idTagihan == ''){
            return self::kembalian(400,$data,'Id Tagihan Tidak Boleh Kosong');
        }
        $data = Yii::$app->db_pembayaran->createCommand("
        SELECT b.`NORM`,b.`NAMA`,b.`ALAMAT`,IF(b.`JENIS_KELAMIN`=1,'L','P') JENIS_KELAMIN,DATE(b.`TANGGAL_LAHIR`) TANGGAL_LAHIR
        ,(DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(),b.TANGGAL_LAHIR)), '%Y')+0) AS umur,
        a.`idTagihan`,SUM(a.`totalTagihan`) totalTagihan,a.`bayar`,a.`status`
        FROM `pembayaran_cokro`.`h2h` a
        LEFT JOIN `master`.`pasien` b ON b.`NORM` = a.`noRm`
        WHERE a.`idTagihan` = '".$idTagihan."' and a.publish = '1' and a.status = '1'
        GROUP BY a.`idTagihan`
        ")->queryOne();
        if($data){
            return self::kembalian(200,$data,'data ditemukan');
        }
        else{
            return self::kembalian(404,$data,'Id Tagihan tidak ditemukan');
        }
    }

    public function actionBayarTagihan()
    {
        // jangan lupa create log request
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = false;
        $idTagihan = Yii::$app->request->post('idTagihan');
        $bayar = Yii::$app->request->post('bayar');
        if($idTagihan == '' || $bayar < 1){
            return self::kembalian(400,$data,'permintaan tidak valid');
        }

        $model = H2h::find()->select('id,idTagihan,noRm,totalTagihan,bayar,status')
            ->where(['idTagihan' => $idTagihan, 'publish' => '1', 'status' => '1'])->all();
        $totaleTotal = 0;
        if(count($model) > 0){
            foreach ($model as $item){
                $totaleTotal = $totaleTotal+$item->totalTagihan;
            }

            if($totaleTotal == $bayar){
                $gagalUpdate = 0;
                foreach ($model as $item){
                    $item->status = '2';
                    $item->bayar = $item->totalTagihan;
                    if(!$item->save()){
                        $gagalUpdate++;
                    }
                }
                if($gagalUpdate){
                    return self::kembalian(500,$model,'pembayaran gagal');
                }
                return self::kembalian(200,$model,'pembayaran berhasil');
            }
            else{
                return self::kembalian(400,$model,'jumlah yang dibayar tidak valid');
            }
        }
        else{
            return self::kembalian(404,$data,'Id Tagihan tidak ditemukan');
        }
    }

    public function actionReversal()
    {
        // jangan lupa create log request
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = false;
        $idTagihan = Yii::$app->request->post('idTagihan');
        if($idTagihan == ''){
            return self::kembalian(400,$data,'permintaan tidak valid');
        }

        $model = H2h::find()->select('id,idTagihan,noRm,totalTagihan,bayar,status')
            ->where(['idTagihan' => $idTagihan, 'publish' => '1', 'status' => '2'])->all();
        if(count($model) > 1){
            return self::kembalian(500,$model,'reversal tidak dapat dilakukan');
        }

        $model = H2h::find()->select('id,idTagihan,noRm,totalTagihan,bayar,status')
            ->where(['idTagihan' => $idTagihan, 'publish' => '1', 'status' => '2'])->one();
        if($model){
            $model->status = '1';
            $model->bayar = 0;
            if($model->save()){
                return self::kembalian(200,$model,'reversal berhasil');
            }
            return self::kembalian(500,$model,'reversal gagal');
        }
        else{
            return self::kembalian(404,$data,'Id Tagihan tidak ditemukan');
        }
    }

    public static function kembalian($statusCode,$data,$message)
    {
        Yii::$app->response->statusCode = $statusCode;
        return [
            'data' => $data,
            'statusCode' => $statusCode,
            'message' => $message
        ];
    }
}
