<?php

namespace app\modules\erm\controllers;

use app\modules\erm\models\IndikatorKeperawatan;
use app\modules\erm\models\search\IndikatorKeperawatan as IndikatorKeperawatanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IndikatorKeperawatanController implements the CRUD actions for IndikatorKeperawatan model.
 */
class IndikatorKeperawatanController extends Controller
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
     * Lists all IndikatorKeperawatan models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new IndikatorKeperawatanSearch(['STATUS' => '1']);
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IndikatorKeperawatan model.
     * @param int $JENIS Jenis
     * @param int $ID ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($JENIS, $ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($JENIS, $ID),
        ]);
    }

    /**
     * Creates a new IndikatorKeperawatan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new IndikatorKeperawatan();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'JENIS' => $model->JENIS, 'ID' => $model->ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing IndikatorKeperawatan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $JENIS Jenis
     * @param int $ID ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($JENIS, $ID)
    {
        $model = $this->findModel($JENIS, $ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'JENIS' => $model->JENIS, 'ID' => $model->ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing IndikatorKeperawatan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $JENIS Jenis
     * @param int $ID ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($JENIS, $ID)
    {
        $model = $this->findModel($JENIS, $ID);
        $model->STATUS = '0';
        $model->save();
        //$this->findModel($JENIS, $ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the IndikatorKeperawatan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $JENIS Jenis
     * @param int $ID ID
     * @return IndikatorKeperawatan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($JENIS, $ID)
    {
        if (($model = IndikatorKeperawatan::findOne(['JENIS' => $JENIS, 'ID' => $ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
