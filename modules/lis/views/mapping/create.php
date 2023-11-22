<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\lis\models\MappingHasil $model */

$this->title = 'Create Mapping Hasil';
$this->params['breadcrumbs'][] = ['label' => 'Mapping Hasils', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mapping-hasil-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
