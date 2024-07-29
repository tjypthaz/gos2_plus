<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\MappingDiagnosaIndikator $model */

$this->title = 'Create Mapping Diagnosa Indikator';
$this->params['breadcrumbs'][] = ['label' => 'Mapping Diagnosa Indikators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapping-diagnosa-indikator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
