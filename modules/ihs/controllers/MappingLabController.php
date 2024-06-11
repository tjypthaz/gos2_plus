<?php

namespace app\modules\ihs\controllers;

use app\modules\ihs\models\TindakanToLoinc;
use app\modules\ihs\models\search\TindakanToLoinc as TindakanToLoincSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MappingLabController implements the CRUD actions for TindakanToLoinc model.
 */
class MappingLabController extends Controller
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
     * Lists all TindakanToLoinc models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TindakanToLoincSearch(['STATUS' => '1']);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TindakanToLoinc model.
     * @param int $TINDAKAN Tindakan
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($TINDAKAN)
    {

        return $this->render('view', [
            'model' => $this->findModel($TINDAKAN),
        ]);
    }

    /**
     * Creates a new TindakanToLoinc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TindakanToLoinc();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if($model->save()){
                    return $this->redirect(['view', 'TINDAKAN' => $model->TINDAKAN]);
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
     * Updates an existing TindakanToLoinc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $TINDAKAN Tindakan
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($TINDAKAN)
    {
        $model = $this->findModel($TINDAKAN);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'TINDAKAN' => $model->TINDAKAN]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TindakanToLoinc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $TINDAKAN Tindakan
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($TINDAKAN)
    {
        $this->findModel($TINDAKAN)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TindakanToLoinc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $TINDAKAN Tindakan
     * @return TindakanToLoinc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($TINDAKAN)
    {
        if (($model = TindakanToLoinc::findOne(['TINDAKAN' => $TINDAKAN])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
