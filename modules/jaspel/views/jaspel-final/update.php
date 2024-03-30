<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\JaspelFinal $model */

$this->title = 'Update Jaspel Final: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jaspel Finals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jaspel-final-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
