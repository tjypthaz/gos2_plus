<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\IndikatorKeperawatan $model */

$this->title = 'Create Indikator Keperawatan';
$this->params['breadcrumbs'][] = ['label' => 'Indikator Keperawatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indikator-keperawatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
