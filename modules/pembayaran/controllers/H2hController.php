<?php

namespace app\modules\pembayaran\controllers;

use app\modules\pembayaran\models\H2h;
use app\modules\pembayaran\models\search\H2h as H2hSearch;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * H2hController implements the CRUD actions for H2h model.
 */
class H2hController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all H2h models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new H2hSearch(['publish' => '1']);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single H2h model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new H2h model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($idTagihan,$noRM)
    {
        //cek sudah kunci / belum
        $isTerkunci = Yii::$app->db_pembayaran->createCommand("
        select KUNCI from `pembayaran`.`tagihan` a where a.ID = '".$idTagihan."' 
        ")->queryScalar();
        if($isTerkunci != '1'){
            Yii::$app->session->setFlash('error','tagihane urung di kunci simgos !!'.$isTerkunci);
            return $this->redirect(['list-tagihan', 'noRm' => $noRM]);
        }
        $model = new H2h();
        $model->idTagihan = $idTagihan;
        $model->noRm = $noRM;
        $dataTagihan = Yii::$app->db_pembayaran->createCommand("
        call pembayaran_cokro.getTotalTagihan('".$idTagihan."');
        ")->queryOne();
        $model->umum = $dataTagihan['umum'] ? $dataTagihan['umum'] : 0;
        $model->naikKelas = $dataTagihan['naikKelas'] ? $dataTagihan['naikKelas'] : 0;
        $model->ambulan = $dataTagihan['ambulan'] ? $dataTagihan['ambulan'] : 0;
        $model->ipj = $dataTagihan['ipj'] ? $dataTagihan['ipj'] : 0;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->totalTagihan = $model->umum + $model->naikKelas + $model->ambulan + $model->ipj;
                if($model->totalTagihan < 1){
                    Yii::$app->session->setFlash('error','tagihan enol, apa yang mau di H2H kan ??');
                    return $this->redirect(['create', 'idTagihan' => $model->idTagihan,'noRM' => $model->noRm]);
                }
                if($model->save()){
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing H2h model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing H2h model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // sebelum hapus cek dulu apakah sudah lunas
        // jika sudah lunas munculkan error tidak bisa di hapus
        // data tidak di hapus, tapi di unpublish
        $model = $this->findModel($id);
        if($model->status == '2'){
            Yii::$app->session->setFlash('error','tagihan sudah lunas !! tidak bisa di hapus');
            return $this->redirect(['index']);
        }
        $model->publish = '2';
        if(!$model->save()){
            Yii::$app->session->setFlash('error',$model->getErrorSummary(true));
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the H2h model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return H2h the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = H2h::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionListTagihan(){
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

        $filter = $filterTgl.$filterRm;
        $sql = "SELECT a.`NOMOR` idReg,a.`NORM` noRm,g.`NAMA` namaPasien,DATE(a.`TANGGAL`) tglDaftar
            ,b.`RUANGAN` idRuangan,c.`DESKRIPSI` tujuan
            ,f.`JENIS` idBayar,h.DESKRIPSI caraBayar,f.`NOMOR` noSep
            ,j.`ID` idTagihan,ROUND(j.TOTAL,0) tagihanRs,j.kunci
            FROM `pendaftaran`.`pendaftaran` a
            LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
            LEFT JOIN `pendaftaran`.`penjamin` f ON f.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`pasien` g ON g.`NORM` = a.`NORM`
            LEFT JOIN (SELECT * FROM `master`.`referensi` WHERE JENIS=10) h ON h.ID = f.`JENIS`
            LEFT JOIN (SELECT * FROM `pembayaran`.`tagihan_pendaftaran` WHERE `UTAMA` = 1 AND `STATUS` = 1) i ON i.PENDAFTARAN = a.`NOMOR`
            LEFT JOIN `pembayaran`.`tagihan` j ON  j.`ID` = i.TAGIHAN 
            WHERE a.`STATUS` = 2 AND b.`STATUS` = 2 AND j.`ID` IS NOT NULL
            ".$filter."
            ORDER BY a.`NOMOR` DESC";
        //echo $sql;
        //exit;
        $data = [];
        if($filter != ""){
            $data = Yii::$app->db_jaspel
                ->createCommand($sql)
                ->queryAll();
        }
        $excelData = htmlspecialchars(Json::encode($data));

        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['noRm','namaPasien','tglDaftar','periode'],
            ],
        ]);

        /*echo "<pre>";
        print_r($data);
        exit;*/

        return $this->render('list',[
            'dataProvider' => $provider,
            'excelData' => $excelData
        ]);
    }
}
