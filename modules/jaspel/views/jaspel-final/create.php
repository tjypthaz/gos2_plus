<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\JaspelFinal $model */

$this->title = 'Create Jaspel Final';
$this->params['breadcrumbs'][] = ['label' => 'Jaspel Finals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jaspel-final-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
