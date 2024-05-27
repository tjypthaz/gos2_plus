<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\Kronis $model */

$this->title = 'Create Kronis';
$this->params['breadcrumbs'][] = ['label' => 'Kronis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kronis-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
