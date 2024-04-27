<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\berkas\models\TerimaBerkas $model */

$this->title = 'Create Terima Berkas';
$this->params['breadcrumbs'][] = ['label' => 'Terima Berkas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terima-berkas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
