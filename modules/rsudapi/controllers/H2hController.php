<?php

namespace app\modules\rsudapi\controllers;

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
            'index' => ['GET'],
            'payment' => ['POST'],
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

    public function actionIndex()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $kode = Yii::$app->request->get('kode');
        if($kode == ''){
            return [
                'data' => [],
                'code' => '05',
                'message' => 'Kode Bayar Tidak Boleh Kosong'
            ];
        }
        return [
            'asd' => 'asd'
        ];
    }
}
