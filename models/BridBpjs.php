<?php


namespace app\models;


use LZCompressor\LZString;
use yii\base\Model;
use yii\helpers\Json;
use yii\httpclient\Client;

class BridBpjs extends Model
{
    const consId = "9921";
    const secretKey = "0hFA4C2062";
    const baseUrl = "https://apijkn.bpjs-kesehatan.go.id/vclaim-rest/";
    const userKey = "30ad818f72d295a3d1242a004376aac8";

    static function stringDecrypt($key, $string){
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        return $output;
    }

    static function decompress($string){
        return LZString::decompressFromEncodedURIComponent($string);
    }

    static function signature(){
        date_default_timezone_set('UTC');
        $tStamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $keyEncrypt = self::consId.self::secretKey.$tStamp;
        $signature = hash_hmac('sha256', self::consId . "&" . $tStamp, self::secretKey, true);
        $encodedSignature = base64_encode($signature);
        return [
            'encodedSignature' => $encodedSignature,
            'keyEncrypt' => $keyEncrypt,
            'tStamp' => $tStamp,
        ];
    }

    public static function vclaim($url,$method,$ctype,$pData=null){
        $signature = BridBpjs::signature();
        $encodedSignature = $signature['encodedSignature'];
        $keyEncrypt = $signature['keyEncrypt'];
        $tStamp = $signature['tStamp'];
        $url = self::baseUrl.$url;
        $client = new Client();
        if($pData){
            $response = $client->createRequest()
                ->setMethod($method)
                ->setUrl($url)
                ->addHeaders([
                    'X-cons-id' => self::consId,
                    'X-timestamp' => $tStamp,
                    'X-signature' => $encodedSignature,
                    'Content-Type' => $ctype,
                    'user_key' => self::userKey
                ])->setContent($pData)
                ->send();
        }else{
            $response = $client->createRequest()
                ->setMethod($method)
                ->setUrl($url)
                ->addHeaders([
                    'X-cons-id' => self::consId,
                    'X-timestamp' => $tStamp,
                    'X-signature' => $encodedSignature,
                    'Content-Type' => $ctype,
                    'user_key' => self::userKey
                ])
                ->send();
        }

        if ($response->isOk) {
            $data = $response->data;
            if ($data['metaData']['code'] == "200") {
                $decr = self::stringDecrypt($keyEncrypt, $data['response']);
                $deco = self::decompress($decr);
                return [
                    'metaData' => [
                        'code' => "200",
                        'message' => "OK"
                    ],
                    'response' => Json::decode($deco)
                ];
            }
            return $data;
        }

        return [
            'metaData' => [
                'code' => "500",
                'message' => "Respon Error"
            ]
        ];
    }
}