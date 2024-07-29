<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\erm\models\DiagnosaKeperawatan $model */

$this->title = 'Create Diagnosa Keperawatan';
$this->params['breadcrumbs'][] = ['label' => 'Diagnosa Keperawatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diagnosa-keperawatan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
