<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\pembayaran\models\PetugasAmbulan $model */

$this->title = 'Tambah Petugas Ambulan';
$this->params['breadcrumbs'][] = ['label' => 'Data Tagihan Ambulan', 'url' => ['tagihan-ambulan/index']];
$this->params['breadcrumbs'][] = ['label' => 'View Tagihan Ambulan', 'url' => ['tagihan-ambulan/view','id' => Yii::$app->request->get('idTagihanAmbulan')]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="petugas-ambulan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'provider' => $provider
    ]) ?>

</div>
