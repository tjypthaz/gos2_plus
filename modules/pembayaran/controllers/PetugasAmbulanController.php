<?php

namespace app\modules\pembayaran\controllers;

use app\modules\pembayaran\models\PetugasAmbulan;
use app\modules\pembayaran\models\search\PetugasAmbulan as PetugasAmbulanSearch;
use app\modules\pembayaran\models\TagihanAmbulan;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PetugasAmbulanController implements the CRUD actions for PetugasAmbulan model.
 */
class PetugasAmbulanController extends Controller
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
     * Lists all PetugasAmbulan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PetugasAmbulanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PetugasAmbulan model.
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
     * Creates a new PetugasAmbulan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($idTagihanAmbulan)
    {
        $cekData = TagihanAmbulan::findOne($idTagihanAmbulan);
        if($cekData->status == '2'){
            Yii::$app->session->setFlash('error','WES LUNAS ORAK ISO TAMBAH PETUGAS !!');
            return $this->redirect(['tagihan-ambulan/index']);
        }
        $model = new PetugasAmbulan();
        $model->idTagihanAmbulan = $idTagihanAmbulan;
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['create', 'idTagihanAmbulan' => $model->idTagihanAmbulan]);
            }
        } else {
            $model->loadDefaultValues();
        }
        $data = Yii::$app->db_pembayaran
            ->createCommand("
            SELECT a.id,b.`NAMA` namaPetugas
            FROM `pembayaran_cokro`.`petugas_ambulan` a
            LEFT JOIN master.`pegawai` b ON b.`ID` = a.`idPegawai`
            WHERE a.`idTagihanAmbulan` = ".$idTagihanAmbulan." AND a.`publish` = 1
            ")
            ->queryAll();

        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [],
            ],
        ]);

        return $this->render('create', [
            'model' => $model,
            'provider' => $provider,
        ]);
    }

    /**
     * Updates an existing PetugasAmbulan model.
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
     * Deletes an existing PetugasAmbulan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$idTagihanAmbulan)
    {
        $model = $this->findModel($id);
        $model->publish = '2';
        if($model->save()){
            Yii::$app->session->setFlash('success','Berhasil Menghapus');
        }else{
            Yii::$app->session->setFlash('error','Gagal Menghapus');
        }

        return $this->redirect(['create','idTagihanAmbulan' => $idTagihanAmbulan]);
    }

    /**
     * Finds the PetugasAmbulan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PetugasAmbulan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PetugasAmbulan::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
