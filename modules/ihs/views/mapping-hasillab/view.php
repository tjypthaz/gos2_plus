<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\ParameterHasilToLoinc $model */

$this->title = $model->PARAMETER_HASIL;
$this->params['breadcrumbs'][] = ['label' => 'Parameter Hasil To Loincs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="parameter-hasil-to-loinc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'PARAMETER_HASIL' => $model->PARAMETER_HASIL], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'PARAMETER_HASIL' => $model->PARAMETER_HASIL], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PARAMETER_HASIL',
            'LOINC_TERMINOLOGI',
            'STATUS',
        ],
    ]) ?>

</div>
