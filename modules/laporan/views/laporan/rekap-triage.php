<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Rekap Triage';
?>
<h1><?= Html::encode($this->title) ?></h1>

<form method="get" action="">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Tanggal Awal</label>
                <input type="date" name="tglAw" value="<?=Yii::$app->request->get('tglAw')?>" class="form-control" required>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="">Tanggal Akhir</label>
                <input type="date" name="tglAk" value="<?=Yii::$app->request->get('tglAk')?>" class="form-control">
            </div>

        </div>
    </div>
    <div class="row mb-2">
        <div class="col text-right">
            <?=Html::button(Icon::show('search')." Cari Data",['class' => 'btn btn-success','type' => 'submit'])?>
        </div>
    </div>
</form>

<h3>Tingkat Kegawatan</h3>
<?= GridView::widget([
    'dataProvider' => $providerTriase,
    'columns' => [
        'RESUSITASI',
        'EMERGENCY',
        'URGENT',
        'LESS_URGENT',
        'NON_URGENT',
        'DOA',
        'tidakDiketahui',
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>

<h3>Asal Rujukan</h3>
<?= GridView::widget([
    'dataProvider' => $providerAsalRujukan,
    'columns' => [
        'jenis',
        'faskes',
        'jml',
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>

<h3>SMF dari SPRI IGD</h3>
<?= GridView::widget([
    'dataProvider' => $providerSmf,
    'columns' => [
        'SMF',
        'jml',
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
