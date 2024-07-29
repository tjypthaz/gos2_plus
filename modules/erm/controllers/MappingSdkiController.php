<?php

namespace app\modules\erm\controllers;

use app\modules\erm\models\MappingDiagnosaIndikator;
use app\modules\erm\models\search\MappingDiagnosaIndikator as MappingDiagnosaIndikatorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MappingSdkiController implements the CRUD actions for MappingDiagnosaIndikator model.
 */
class MappingSdkiController extends Controller
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
     * Lists all MappingDiagnosaIndikator models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MappingDiagnosaIndikatorSearch(['STATUS' => '1']);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MappingDiagnosaIndikator model.
     * @param int $ID ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID),
        ]);
    }

    /**
     * Creates a new MappingDiagnosaIndikator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MappingDiagnosaIndikator();

        if ($this->request->isPost) {
            /*echo "<pre>";
            print_r($pecahIndikator);
            exit;*/
            if ($model->load($this->request->post())) {
                $pecahIndikator = explode('-',$this->request->post()['MappingDiagnosaIndikator']['INDIKATOR']);
                $model->JENIS = $pecahIndikator[0];
                $model->INDIKATOR = $pecahIndikator[1];
                if($model->save()){
                    return $this->redirect(['view', 'ID' => $model->ID]);
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
     * Updates an existing MappingDiagnosaIndikator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ID ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID)
    {
        $model = $this->findModel($ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MappingDiagnosaIndikator model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ID ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID)
    {
        $model = $this->findModel($ID);
        $model->STATUS = '0';
        $model->save();
        //$this->findModel($ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MappingDiagnosaIndikator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ID ID
     * @return MappingDiagnosaIndikator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = MappingDiagnosaIndikator::findOne(['ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
