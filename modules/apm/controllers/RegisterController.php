<?php

namespace app\modules\apm\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for the `apm` module
 */
class RegisterController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFormRm($jaminan)
    {
        if(Yii::$app->request->post()){
            // cari data pasien disini
            if(Yii::$app->request->post('norm') == "00000001"){
                /*
                 * pengecekan data
                 * apakah pasien punya nomer kartu bpjs
                 * kartu bpjs masih aktif ?
                 * jika tidak aktif, redirect ke halaman awal dan munculkan error "pasien tidak aktif"
                 * sudah melakukan finger print ? tampilkan response ke layar form register
                 * punya nomer kontrol hari ini ?
                 * jika punya, masuk ke form register
                 * jika tidak punya, punya rujukan dari faskes 1 yang masih aktif ?
                 * jika punya, tampilkan list rujukan, pilih rujukan, masuk ke form register
                 * jika tidak punya rujukan, redirect ke halaman awal dan munculkan error "rujukan faskes 1 tidak ditemukan"
                 *
                 * sebelum masuk form register, cek jadwal dokter
                 * setelah submit, cek kuota, jika kuota habis, tampilkan error
                 * KLL(ortopedi) hanya loket/online?, jika lewat apm, redirect ke halaman awal dan munculkan error "ort lewat loket /online ?"
                 *
                 * masih blm pasti FLOW nya ????
                 * tembak SEP, jika gagal, redirect ke halaman awal dan munculkan error
                 * tembak daftar
                 * tembak antrean bpjs
                 * printout nomor antrean
                 *
                */

                $nobpjs = true;
                $bpjsaktif = true;
                $kontrol = false;

                if($nobpjs){
                    if($bpjsaktif){
                        if($kontrol){
                            return Yii::$app->response->redirect([
                                'apm/register/form-reg',
                                'norm' => Yii::$app->request->post('norm'),
                                'noKontrol' => 'NoKontrolll',
                                'jaminan' => $jaminan
                            ]);
                        }
                        else{
                            if($jaminan == '5'){
                                return Yii::$app->response->redirect([
                                    'apm/register/list-rujukan',
                                    'norm' => Yii::$app->request->post('norm'),
                                    'jaminan' => $jaminan
                                ]);
                            }
                            return Yii::$app->response->redirect([
                                'apm/register/form-reg',
                                'norm' => Yii::$app->request->post('norm'),
                                'jaminan' => $jaminan
                            ]);
                        }
                    }
                    else{
                        Yii::$app->session->setFlash('error','Nomor BPJS `Nama Pasien` Tidak Aktif');
                        return Yii::$app->response->redirect('index');
                    }
                }
                else{
                    Yii::$app->session->setFlash('error','Nomor BPJS Tidak Ditemukan');
                    return Yii::$app->response->redirect('index');
                }
            }
            else{
                $message = 'Nomer RM '.Yii::$app->request->post('norm').' Tidak Ditemukan';
                Yii::$app->session->setFlash('error',$message);
                return Yii::$app->response->redirect('index');
            }
        }

        return $this->render('formrm',[
            'jaminan' => $jaminan
        ]);
    }

    public function actionFormReg($norm,$jaminan,$noKontrol=null,$noRujukan=null){
        $dataPasien = [
            'norm' => $norm,
            'nobpjs' => '002324089038',
            'nama' => 'Askhan Naoki ALfaro',
            'tglLahir' => '01-01-2000'
        ];
        // jika jaminan == 5 maka
        // jika nokontrol != null ada maka cari data kontrol di BPJS
        // jika nokontrol == null dan norujukan != null maka cari data rujukan di BPJS
        // cek finger

        // jika jaminan == 1 maka

        // cari jadwal dokter hari ini
        // dari jadwal bisa ngecreate list poli kudune

        return $this->render('formreg',[
            'dataPasien' => $dataPasien,
            'kontrol' => [
                'nokontrol' => $noKontrol,
                'poli' => 'POLI'
            ],
            'rujukan' => [
                'norujukan' => $noRujukan
            ],
            'jaminan' => $jaminan,
            'listPoli' => $listPoli=null,
            'listDokter' => $listDokter=null
        ]);
    }

    public function actionListRujukan($norm,$jaminan){
        if($jaminan != '5'){
            Yii::$app->session->setFlash('error','Anda Mau Kemana ?');
            return Yii::$app->response->redirect('index');
        }
        // norm digunakan untuk mencari nomer bpjs, kemudian mencari rujukan di bpjs
        $rujukan = true;
        if($rujukan){
            $listRujukan = [
                0 => [
                    'norujukan' => 'AAAA',
                    'poli' => 'AA'
                ],
                1 => [
                    'norujukan' => 'BBBB',
                    'poli' => 'BB'
                ],
            ];
            return $this->render('listrujukan',[
                'norm' => $norm,
                'listRujukan' => $listRujukan,
                'jaminan' => $jaminan
            ]);
        }
        else{
            Yii::$app->session->setFlash('error','Rujukan Faskes 1 Tidak Ditemukan');
            return Yii::$app->response->redirect('index');
        }
    }
}
