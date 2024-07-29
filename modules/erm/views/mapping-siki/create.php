<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\MappingIntervensiIndikator $model */

$this->title = 'Create Mapping Intervensi Indikator';
$this->params['breadcrumbs'][] = ['label' => 'Mapping Intervensi Indikators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapping-intervensi-indikator-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
