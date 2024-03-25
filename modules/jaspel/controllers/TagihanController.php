<?php

namespace app\modules\jaspel\controllers;

use app\modules\jaspel\models\Jaspel;
use app\modules\jaspel\models\JaspelFinal;
use app\modules\jaspel\models\JaspelTemp;
use Yii;
use yii\base\DynamicModel;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * Default controller for the `jaspel` module
 */
class TagihanController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $filterTgl = "";
        $tglAw = Yii::$app->request->get('tglAw');
        if($tglAw != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) = '".$tglAw."'";
        }

        $tglAk = Yii::$app->request->get('tglAk');
        if($tglAw != "" && $tglAk != ""){
            $filterTgl = " and DATE(a.`TANGGAL`) between '".$tglAw."' and '".$tglAk."'";
        }

        $filterRm = "";
        $noRm = Yii::$app->request->get('noRm');
        if($noRm != ""){
            $filterRm = " and a.`NORM` = '".$noRm."'";
        }

        $filterCb = "";
        $caraBayar = Yii::$app->request->get('caraBayar');
        if($caraBayar != ""){
            $filterCb = " and f.`JENIS` = '".$caraBayar."'";
        }

        $filter = $filterTgl.$filterRm.$filterCb;
        $sql = "SELECT a.`NOMOR` idReg,a.`NORM` noRm,g.`NAMA` namaPasien,DATE(a.`TANGGAL`) tgl,a.`PAKET` paket
            ,b.`RUANGAN` idRuangan,b.`DOKTER` idDokter,c.`DESKRIPSI` tujuan,e.`NAMA` dpjp
            ,f.`JENIS` idBayar,h.DESKRIPSI caraBayar,f.`NOMOR` noSep
            ,j.`ID` idTagihan,ROUND(j.TOTAL,0) tagihanRs,ROUND(k.`TARIFCBG`,0) klaim
            ,CONCAT(l.`bulan`,'-',l.`tahun`) periode
            FROM `pendaftaran`.`pendaftaran` a
            LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
            LEFT JOIN `master`.`dokter` d ON d.`ID` = b.`DOKTER`
            LEFT JOIN `master`.`pegawai` e ON e.`NIP` = d.`NIP`
            LEFT JOIN `pendaftaran`.`penjamin` f ON f.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`pasien` g ON g.`NORM` = a.`NORM`
            LEFT JOIN (SELECT * FROM `master`.`referensi` WHERE JENIS=10) h ON h.ID = f.`JENIS`
            LEFT JOIN (SELECT * FROM `pembayaran`.`tagihan_pendaftaran` WHERE `UTAMA` = 1 AND `STATUS` = 1) i ON i.PENDAFTARAN = a.`NOMOR`
            LEFT JOIN `pembayaran`.`tagihan` j ON  j.`ID` = i.TAGIHAN 
            LEFT JOIN `inacbg`.`hasil_grouping` k ON k.`TAGIHAN_ID` = i.TAGIHAN
            LEFT JOIN `jaspel_cokro`.`jaspel` l ON l.`idReg` = a.`NOMOR` and l.publish = 1
            WHERE a.`STATUS` = 2 AND b.`STATUS` = 2 AND j.`ID` IS NOT NULL
            ".$filter."
            ORDER BY a.`NOMOR` ASC";

        $data = [];
        if($filter != ""){
            $data = Yii::$app->db_jaspel
                ->createCommand($sql)
                ->queryAll();
        }
        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['tgl'],
            ],
        ]);


        /*echo "<pre>";
        print_r($data);
        exit;*/

        return $this->render('index',[
            'dataProvider' => $provider
        ]);
    }

    public function actionDetailTagihan($idReg)
    {
        if(!Yii::$app->session->has('bulan') || !Yii::$app->session->has('tahun'))
        {
            return $this->redirect(['periode']);
        }

        $filterIdReg = "";
        if($idReg!= ""){
            $filterIdReg = " and a.`NOMOR` = ".$idReg;
        }

        $filter = $filterIdReg;
        $sql = "SELECT a.`NOMOR` idReg,a.`NORM` noRm,g.`NAMA` namaPasien,DATE(a.`TANGGAL`) tgl,a.`PAKET` paket
            ,b.`RUANGAN` idRuangan,b.`DOKTER` idDokter,c.`DESKRIPSI` tujuan,e.`NAMA` dpjp
            ,f.`JENIS` idBayar,h.DESKRIPSI caraBayar,f.`NOMOR` noSep
            ,j.`ID` idTagihan,ROUND(j.TOTAL,0) tagihanRs,ROUND(k.`TARIFCBG`,0) klaim
            ,CONCAT(l.`bulan`,'-',l.`tahun`) periode, jaspel_cokro.`getJpTarif`(j.`ID`) totalJaspel,l.`id`
            FROM `pendaftaran`.`pendaftaran` a
            LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
            LEFT JOIN `master`.`dokter` d ON d.`ID` = b.`DOKTER`
            LEFT JOIN `master`.`pegawai` e ON e.`NIP` = d.`NIP`
            LEFT JOIN `pendaftaran`.`penjamin` f ON f.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`pasien` g ON g.`NORM` = a.`NORM`
            LEFT JOIN (SELECT * FROM `master`.`referensi` WHERE JENIS=10) h ON h.ID = f.`JENIS`
            LEFT JOIN (SELECT * FROM `pembayaran`.`tagihan_pendaftaran` WHERE `UTAMA` = 1 AND `STATUS` = 1) i ON i.PENDAFTARAN = a.`NOMOR`
            LEFT JOIN `pembayaran`.`tagihan` j ON  j.`ID` = i.TAGIHAN 
            LEFT JOIN `inacbg`.`hasil_grouping` k ON k.`TAGIHAN_ID` = i.TAGIHAN
            LEFT JOIN `jaspel_cokro`.`jaspel` l ON l.`idReg` = a.`NOMOR` and l.publish = 1
            WHERE a.`STATUS` = 2 AND b.`STATUS` = 2 AND j.`ID` IS NOT NULL
            ".$filter."
            ORDER BY a.`NOMOR` ASC";

        $data = [];
        if($filter != ""){
            $data = Yii::$app->db_jaspel
                ->createCommand($sql)
                ->queryOne();
        }
        if(!$data){
            Yii::$app->session->setFlash('error','Data tidak ditemukan');
            return $this->redirect(['index']);
        }

        if($data['periode'] != ''){
            return $this->redirect(['jaspel-temp','id' => $data['id']]);
        }

        /*echo "<pre>";
        print_r($listCarabayar);
        exit;*/

        return $this->render('detail',[
            'data' => $data
        ]);
    }

    public function actionPeriode()
    {
        $model = new DynamicModel(compact('bulan', 'tahun'));
        $model->addRule(['bulan', 'tahun'], 'integer')
            ->addRule(['bulan', 'tahun'], 'required');
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if($model->validate()){
                Yii::$app->session->set('bulan',$model->bulan);
                Yii::$app->session->set('tahun',$model->tahun);
                return $this->redirect(['periode']);
            }
        }

        return $this->render('periode',[
            'model' => $model
        ]);
    }

    public function actionSimpanTemp()
    {
        if (Yii::$app->request->isPost) {
            /*echo "<pre>";
            print_r(Yii::$app->request->post());exit;*/
            $model = new Jaspel();
            $model->bulan = Yii::$app->request->post('bulan');
            $model->tahun = Yii::$app->request->post('tahun');
            $model->idReg = Yii::$app->request->post('idReg');
            $model->tgl = Yii::$app->request->post('tgl');
            $model->noRm = Yii::$app->request->post('noRm');
            $model->namaPasien = Yii::$app->request->post('namaPasien');
            $model->idTagihan = Yii::$app->request->post('idTagihan');
            $model->idCaraBayar = Yii::$app->request->post('idBayar');
            $model->caraBayar = Yii::$app->request->post('caraBayar');
            $model->tagihanRs = Yii::$app->request->post('tarifrs');
            $model->jpRs = Yii::$app->request->post('jaspel');
            if(Yii::$app->request->post('is_prop') == '1'){
                $model->klaim = Yii::$app->request->post('klaim');
                $model->jpFix = (Yii::$app->request->post('jp_prop') / 100) * $model->klaim;
            }
            else{
                $model->klaim = Yii::$app->request->post('tarifrs');
                $model->jpFix = $model->jpRs;
            }

            if($model->save()){
                $model->id;
                $sql = "INSERT INTO`jaspel_cokro`.`jaspel_temp` 
                (`idJaspel`,`idRuangan`,`idTindakanMedis`,`idTindakan`,`idDokterO`,`jpDokterO`,`idDokterL`,`jpDokterL`,`idPara`,`jpPara`,`jpPegawai`)
                SELECT ".$model->id.",e.`RUANGAN`,d.`ID` idTindakanMedis,b.`TINDAKAN`,`getDokterO`(d.`ID`)
                ,(b.`DOKTER_OPERATOR`+b.`DOKTER_ANASTESI`) jpDokterO,'0' idDokterL, b.`DOKTER_LAINNYA` jpDokterL, `getPara`(d.`ID`)
                ,(b.`PENATA_ANASTESI`+b.`PARAMEDIS`) jpPara,b.`NON_MEDIS` jpPegawai
                FROM `pembayaran`.`rincian_tagihan` a
                LEFT JOIN `master`.`tarif_tindakan` b ON a.`TARIF_ID` = b.`ID`
                LEFT JOIN `layanan`.`tindakan_medis` d ON d.`ID` = a.`REF_ID`
                LEFT JOIN `pendaftaran`.`kunjungan` e ON e.`NOMOR` = d.`KUNJUNGAN`
                LEFT JOIN `master`.`ruangan` f ON f.`ID` = e.`RUANGAN`
                WHERE a.`TAGIHAN` = '".$model->idTagihan."' AND a.`STATUS` = 1 AND a.`JENIS` = 3
                UNION ALL
                SELECT ".$model->id.",'1030102' RUANGAN,a.`REF_ID`,'Obat' TINDAKAN,'0' idDokterO ,'0' jpDokterO,'0' idDokterL,'0' jpDokterL
                ,'4' idPara,IFNULL(ROUND((SUM((a.`JUMLAH`*a.`TARIF`)) * 0.08) * 0.6,0),0) jpPara
                ,IFNULL(ROUND((SUM((a.`JUMLAH`*a.`TARIF`)) * 0.08) * 0.4,0),0) jpPegawai
                FROM `pembayaran`.`rincian_tagihan` a
                WHERE a.`TAGIHAN` = '".$model->idTagihan."' AND a.`JENIS` = 4 AND a.`STATUS` = 1";
                Yii::$app->db_jaspel
                    ->createCommand($sql)
                    ->execute();
                Yii::$app->session->setFlash('success','Berhasil Hitung Sementara');
                return $this->redirect(['jaspel-temp','id' => $model->id]);
            }
            else{
                Yii::$app->session->setFlash('error',$model->getErrorSummary(true));
                return $this->redirect(['detail-tagihan','idReg' => Yii::$app->request->post('idReg')]);
            }
        }

        Yii::$app->session->setFlash('error','Error Tidak Diketahui');
        return $this->redirect(['index']);
    }

    public function actionJaspelTemp($id)
    {
        $dataFinal = JaspelFinal::find()->where(['idJaspel' => $id])->one();
        if($dataFinal){
            return $this->redirect(['jaspel-final','id' => $id]);
        }
        $dataHeader = Jaspel::findOne($id);
        $dataTemp = Yii::$app->db_jaspel
            ->createCommand("CALL getJaspelTemp(".$id.");")
            ->queryAll();

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

        return $this->render('jaspel_temp',[
            'dataHeader' => $dataHeader,
            'dataTemp' => $dataTemp,
            'listDokter' => $listDokter,
            'listJenisPara' => $listJenisPara,
        ]);
    }

    public function actionPilihPara($id,$jenis)
    {
        $model = JaspelTemp::findOne($id);
        $model->idPara = $jenis;
        if($model->save()){
            return "ok";
        }
        return "nok";
    }

    public function actionPilihDokterO($id,$idDokter)
    {
        $model = JaspelTemp::findOne($id);
        $model->idDokterO = $idDokter;
        if($model->save()){
            return "ok";
        }
        return "nok";
    }

    public function actionPilihDokterL($id,$idDokter)
    {
        $model = JaspelTemp::findOne($id);
        $model->idDokterL = $idDokter;
        if($model->save()){
            return "ok";
        }
        return "nok";
    }

    public function actionHapusJaspeltemp($id,$idReg)
    {
        $model = Jaspel::findOne($id);
        $model->publish = 2;
        if($model->save()){
            Yii::$app->session->setFlash('success','Hapus Perhitungan Berhasil');
            return $this->redirect(['detail-tagihan','idReg' => $idReg]);
        }
        Yii::$app->session->setFlash('error','Hapus Perhitungan Gagal');
        return $this->redirect(['jaspel-temp','id' => $id]);
    }

    public function actionFinalJaspeltemp($id)
    {
        // cek masih ada yang harus di input / tidak
        $sql = "SELECT SUM((IF(a.`jpDokterO` > 0,IF(a.`idDokterO` > 0,0,1),0) + IF(a.`jpDokterL` > 0,IF(a.`idDokterL` > 0,0,1),0) + IF(a.`jpPara` > 0,IF(a.`idPara` > 0,0,1),0))) input
            FROM jaspel_cokro.jaspel_temp a
            WHERE idjaspel = ".$id;
        $isFinish = Yii::$app->db_jaspel
            ->createCommand($sql)
            ->queryScalar();
        if($isFinish > 0){
            Yii::$app->session->setFlash('error','Perhitungan Final Gagal, Penerima Jaspel masih Kosong');
            return $this->redirect(['jaspel-temp','id' => $id]);
        }

        Yii::$app->db_jaspel
            ->createCommand("call finalJaspel(".$id.")")
            ->execute();
        Yii::$app->session->setFlash('success','Simpan Perhitungan Final Berhasil');
        return $this->redirect(['jaspel-final','id' => $id]);
    }

    public function actionJaspelFinal($id)
    {
        $dataHeader = Jaspel::findOne($id);
        $dataFinal = JaspelFinal::find()->where(['idJaspel' => $id])->all();
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
        /*echo "<pre>";
        print_r($listJenisPara);
        exit;*/
        return $this->render('jaspel_final',[
            'dataHeader' => $dataHeader,
            'dataFinal' => $dataFinal,
            'listDokter' => $listDokter,
            'listJenisPara' => $listJenisPara,
        ]);
    }
}
