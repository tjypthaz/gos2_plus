<?php

namespace app\modules\ihs\controllers;

use app\modules\ihs\models\ParameterHasilToLoinc;
use app\modules\ihs\models\search\ParameterHasilToLoinc as ParameterHasilToLoincSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MappingHasillabController implements the CRUD actions for ParameterHasilToLoinc model.
 */
class MappingHasillabController extends Controller
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
     * Lists all ParameterHasilToLoinc models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ParameterHasilToLoincSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ParameterHasilToLoinc model.
     * @param int $PARAMETER_HASIL Parameter Hasil
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($PARAMETER_HASIL)
    {
        return $this->render('view', [
            'model' => $this->findModel($PARAMETER_HASIL),
        ]);
    }

    /**
     * Creates a new ParameterHasilToLoinc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($ID)
    {
        $model = new ParameterHasilToLoinc();
        $model->PARAMETER_HASIL = $ID;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->goBack();
                //return $this->redirect(['view', 'PARAMETER_HASIL' => $model->PARAMETER_HASIL]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ParameterHasilToLoinc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $PARAMETER_HASIL Parameter Hasil
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($PARAMETER_HASIL)
    {
        $model = $this->findModel($PARAMETER_HASIL);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'PARAMETER_HASIL' => $model->PARAMETER_HASIL]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ParameterHasilToLoinc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $PARAMETER_HASIL Parameter Hasil
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($PARAMETER_HASIL)
    {
        $this->findModel($PARAMETER_HASIL)->delete();

        return $this->goBack();
    }

    /**
     * Finds the ParameterHasilToLoinc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $PARAMETER_HASIL Parameter Hasil
     * @return ParameterHasilToLoinc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($PARAMETER_HASIL)
    {
        if (($model = ParameterHasilToLoinc::findOne(['PARAMETER_HASIL' => $PARAMETER_HASIL])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
