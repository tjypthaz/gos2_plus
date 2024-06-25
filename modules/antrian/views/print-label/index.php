<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Auto Print Label';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'font-size:10px;'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'nOpen',
        'NORM',
        'NAMA',
        'create_date',
        'statusPrint',
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>

<?php
$js=<<<js
    $(document).ready(function() {
        window.setTimeout( function() {
          window.location.reload();
        }, 30000);
    });    
js;
$this->registerJs($js);
?>
