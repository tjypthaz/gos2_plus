<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\JenisIndikatorKeperawatan $model */

$this->title = 'Create Jenis Indikator Keperawatan';
$this->params['breadcrumbs'][] = ['label' => 'Jenis Indikator Keperawatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-indikator-keperawatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
