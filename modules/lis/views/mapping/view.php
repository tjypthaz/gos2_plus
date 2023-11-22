<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\lis\models\MappingHasil $model */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Mapping Hasils', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mapping-hasil-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID], [
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
            'ID',
            'VENDOR_LIS',
            'LIS_KODE_TEST',
            'PREFIX_KODE',
            'HIS_KODE_TEST',
            'PARAMETER_TINDAKAN_LAB',
        ],
    ]) ?>

</div>
