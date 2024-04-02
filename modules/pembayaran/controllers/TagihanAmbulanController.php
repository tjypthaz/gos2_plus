<?php

namespace app\modules\pembayaran\controllers;

use app\modules\pembayaran\models\TagihanAmbulan;
use app\modules\pembayaran\models\search\TagihanAmbulan as TagihanAmbulanSearch;
use kartik\mpdf\Pdf;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagihanAmbulanController implements the CRUD actions for TagihanAmbulan model.
 */
class TagihanAmbulanController extends Controller
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
     * Lists all TagihanAmbulan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TagihanAmbulanSearch(['publish' => '1']);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TagihanAmbulan model.
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
     * Creates a new TagihanAmbulan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($idTagihan,$noRm,$namaPasien)
    {
        $model = new TagihanAmbulan();
        $model->idTagihan = $idTagihan;
        $model->noRm = $noRm;
        $model->namaPasien = $namaPasien;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                Yii::$app->session->setFlash('error',$model->getErrorSummary(true));
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TagihanAmbulan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        // jika sudah dilunasi tidak bisa di update
        $model = $this->findModel($id);
        if($model->status == '2'){
            Yii::$app->session->setFlash('error','Sudah Lunas Tidak Bisa DIUBAH !!');
            return $this->redirect(['index']);
        }

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TagihanAmbulan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        if($model->status == '2'){
            Yii::$app->session->setFlash('error','Sudah Lunas Tidak Bisa DIHAPUS !!');
        }else{
            $model->publish = '2';
            if($model->save()){
                Yii::$app->session->setFlash('success','Tagihan Berhasil Dihapus');
            }else{
                Yii::$app->session->setFlash('error','Tagihan Gagal Dihapus, Hub IT');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the TagihanAmbulan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TagihanAmbulan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TagihanAmbulan::findOne(['id' => $id])) !== null) {
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
        $sql = "SELECT a.`NOMOR` idReg,a.`NORM` noRm,g.`NAMA` namaPasien,DATE(a.`TANGGAL`) tgl
            ,b.`RUANGAN` idRuangan,c.`DESKRIPSI` tujuan
            ,f.`JENIS` idBayar,h.DESKRIPSI caraBayar,f.`NOMOR` noSep
            ,j.`ID` idTagihan,ROUND(j.TOTAL,0) tagihanRs
            FROM `pendaftaran`.`pendaftaran` a
            LEFT JOIN `pendaftaran`.`tujuan_pasien` b ON b.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`ruangan` c ON c.`ID` = b.`RUANGAN`
            LEFT JOIN `pendaftaran`.`penjamin` f ON f.`NOPEN` = a.`NOMOR`
            LEFT JOIN `master`.`pasien` g ON g.`NORM` = a.`NORM`
            LEFT JOIN (SELECT * FROM `master`.`referensi` WHERE JENIS=10) h ON h.ID = f.`JENIS`
            LEFT JOIN (SELECT * FROM `pembayaran`.`tagihan_pendaftaran` WHERE `UTAMA` = 1 AND `STATUS` = 1) i ON i.PENDAFTARAN = a.`NOMOR`
            LEFT JOIN `pembayaran`.`tagihan` j ON  j.`ID` = i.TAGIHAN 
            WHERE a.`STATUS` = 2 AND b.`STATUS` = 2 AND j.`ID` IS NOT NULL AND c.`JENIS_KUNJUNGAN` IN (2,3)
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
                'attributes' => ['noRm','tgl','klaim','periode'],
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

    public function actionLunas($id)
    {
        $model = $this->findModel($id);
        if($model->status == '2'){
            return $this->redirect(['index']);
        }

        $model->status = '2';
        if($model->save()){
            Yii::$app->session->setFlash('success','Pelunasan Berhasil');
        }else{
            Yii::$app->session->setFlash('error','Pelunasan Gagal, Hub IT');
        }

        return $this->redirect(['index']);
    }

    public function actionPrint($id){
        $data = TagihanAmbulan::findOne($id);
        if($data->status != '2'){
            Yii::$app->session->setFlash('error', 'Dilunasi Dulu Bosku');
            return $this->redirect(['index']);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'format' => [210, 140], // here define custom [width, height] in mm
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('kwitansi',[
                'data' => $data
            ]),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'options' => [
                // any mpdf options you wish to set
            ],
            'methods' => [
                'SetTitle' => 'RSUD RAA TJOKRONEGORO',
                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['RSUD RAA TJOKRONEGORO PURWOREJO||Nomor : '.$data->idTagihan.' '],
                'SetFooter' => ['||Dicetak pada tanggal : ' . date("Y-m-d H:i:s")],
                'SetAuthor' => 'RSUD RAA TJOKRONEGORO',
                'SetCreator' => 'RSUD RAA TJOKRONEGORO',
                'SetKeywords' => 'RSUD RAA TJOKRONEGORO',
            ]
        ]);
        return $pdf->render();
    }
}
