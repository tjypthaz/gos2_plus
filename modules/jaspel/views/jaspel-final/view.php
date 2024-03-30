<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\jaspel\models\JaspelFinal $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jaspel Finals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="jaspel-final-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'idJaspel',
            'idRuangan',
            'ruangan',
            'tindakan',
            'idDokterO',
            'idDokterL',
            'idPara',
            'namaDokterO',
            'namaDokterL',
            'jenisPara',
            'jpDokterO',
            'jpDokterL',
            'jpPara',
            'jpStruktural',
            'jpBlud',
            'jpPegawai',
        ],
    ]) ?>

</div>
