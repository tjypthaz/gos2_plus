<?php

namespace app\modules\apm\controllers;

use yii\web\Controller;

/**
 * Default controller for the `apm` module
 */
class RegisApmController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
