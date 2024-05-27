<?php

namespace app\modules\jaspel\controllers;

use app\modules\jaspel\models\Kronis;
use app\modules\jaspel\models\search\Kronis as KronisSearch;
use yii\base\DynamicModel;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * KronisController implements the CRUD actions for Kronis model.
 */
class KronisController extends Controller
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
     * Lists all Kronis models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new KronisSearch(['publish' => '1']);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kronis model.
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
     * Creates a new Kronis model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Kronis();

        if ($this->request->isPost) {

            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpload(){
        $model = new DynamicModel(compact('fileExcel'));
        $model->addRule(['fileExcel'], 'file', ['skipOnEmpty' => false, 'extensions' => 'xls, xlsx']);

        if ($this->request->isPost) {
            $uploadedFile = \yii\web\UploadedFile::getInstance($model,'fileExcel');
            $extension = $uploadedFile->extension;
            if($extension == 'xlsx'){
                $inputFileType = 'Xlsx';
            }else{
                $inputFileType = 'Xls';
            }
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($uploadedFile->tempName);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $data = [];
            for ($row = 2; $row <= $highestRow; ++$row) {
                $kolom1 = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $kolom2 = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $kolom3 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $data[] = [
                    strtoupper($kolom1), $kolom2, $kolom3
                ];
            }
            Yii::$app->db_jaspel->createCommand("truncate temp_kronis")->execute();
            Yii::$app->db_jaspel->createCommand()->batchInsert('temp_kronis',[
                'noSep','totalKronis','klaimKronis'
            ],$data)->execute();
            return $this->redirect(['temp']);
        }

        return $this->render('upload', [
            'model' => $model,
        ]);
    }

    public function actionTemp(){
        $sql = "SELECT a.`noSep`,a.`totalKronis`,a.`klaimKronis`,b.`NOPEN` idReg
        FROM `jaspel_cokro`.`temp_kronis` a
        LEFT JOIN `pendaftaran`.`penjamin` b ON b.`NOMOR` = a.`noSep`
        order by a.noSep asc";
        $data = Yii::$app->db_jaspel
            ->createCommand($sql)
            ->queryAll();

        $provider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => ['noSep','totalKronis','klaimKronis','idReg'],
            ],
        ]);

        return $this->render('temp',[
            'dataProvider' => $provider,
        ]);
    }

    public function actionCreateBatch(){
        $user = Yii::$app->user->identity->username;
        Yii::$app->db_jaspel->createCommand("
        INSERT INTO `kronis` (`idReg`,`noSep`,`tarifKronis`,`klaimKronis`,`createBy`,`createDate`)
        SELECT b.`NOPEN`,a.`noSep`,IF(a.`totalKronis` > 0,a.`totalKronis`,0),
               IF(a.`klaimKronis` > 0,a.`klaimKronis`,0),'".$user."',NOW()
        FROM `jaspel_cokro`.`temp_kronis` a
        LEFT JOIN `pendaftaran`.`penjamin` b ON b.`NOMOR` = a.`noSep`
        ")->execute();
        return $this->redirect(['index']);
    }

    public function actionUpdateBatch(){
        $user = Yii::$app->user->identity->username;
        Yii::$app->db_jaspel->createCommand("
        UPDATE `jaspel_cokro`.`kronis` a
        LEFT JOIN `jaspel_cokro`.`temp_kronis` b ON b.`noSep` = a.`noSep`
        SET
        a.`tarifKronis` = IF(b.`totalKronis` > 0,b.`totalKronis`,0),
        a.`klaimKronis` = IF(b.`klaimKronis` > 0,b.`klaimKronis`,0),
        a.`updateBy` = '".$user."',
        a.`updateDate` = NOW()
        WHERE a.`noSep` = b.`noSep`
        ")->execute();
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Kronis model.
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
     * Deletes an existing Kronis model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->publish = '2';
        if($model->save()){
            Yii::$app->session->setFlash('success','hapus berhasil');
        }else{
            Yii::$app->session->setFlash('error','hapus gagal');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kronis model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Kronis the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kronis::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
