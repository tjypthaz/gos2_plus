<?php

namespace app\modules\erm\controllers;

use app\modules\erm\models\MappingIntervensiIndikator;
use app\modules\erm\models\search\MappingIntervensiIndikator as MappingIntervensiIndikatorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MappingSikiController implements the CRUD actions for MappingIntervensiIndikator model.
 */
class MappingSikiController extends Controller
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
     * Lists all MappingIntervensiIndikator models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MappingIntervensiIndikatorSearch(['STATUS' => '1']);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MappingIntervensiIndikator model.
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
     * Creates a new MappingIntervensiIndikator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MappingIntervensiIndikator();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $pecahIndikator = explode('-',$this->request->post()['MappingIntervensiIndikator']['INDIKATOR']);
                $model->JENIS = $pecahIndikator[0];
                $model->INDIKATOR = $pecahIndikator[1];
                if($model->save()){
                    return $this->redirect(['view', 'ID' => $model->ID]);
                }

            }
            /*if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'ID' => $model->ID]);
            }*/
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MappingIntervensiIndikator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ID ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID)
    {
        $model = $this->findModel($ID);
        $model->INDIKATOR = $model->JENIS.'-'.$model->INDIKATOR;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $pecahIndikator = explode('-',$this->request->post()['MappingIntervensiIndikator']['INDIKATOR']);
            $model->JENIS = $pecahIndikator[0];
            $model->INDIKATOR = $pecahIndikator[1];

            if($model->save()){
                return $this->redirect(['view', 'ID' => $model->ID]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MappingIntervensiIndikator model.
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
     * Finds the MappingIntervensiIndikator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ID ID
     * @return MappingIntervensiIndikator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = MappingIntervensiIndikator::findOne(['ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
