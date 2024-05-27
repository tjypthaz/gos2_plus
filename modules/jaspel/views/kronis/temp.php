<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Kronis Temporary';
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="row">
    <div class="col">
        <?=Html::a('Insert New Data Kronis',['kronis/create-batch'],['class' => 'btn btn-warning'])?>
    </div>
    <div class="col">
        <div class="text-right">
            <?=Html::a('Update Data Kronis',['kronis/update-batch'],['class' => 'btn btn-info'])?>
        </div>

    </div>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'options' => ['style' => 'font-size:11px;'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'noSep',
        'totalKronis',
        'klaimKronis',
        'idReg',
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
