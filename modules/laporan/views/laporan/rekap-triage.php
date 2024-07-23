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
<?php
if($excelDataTriase != '[]'){
    $header = [
        'Resusitasi',
        'Emergency',
        'Urgent',
        'Less Urgent',
        'Non Urgent',
        'Doa',
        'Tidak Diketahui'
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
    <div class="row">
        <div class="col text-right">
            <form action="<?= Url::toRoute(['toexcel'])?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="namaFile" value="Tingkat Kegawatan">
                <textarea name="excelData" style="display: none;">
            <?=$excelDataTriase?>
            </textarea>
                <textarea name="header" style="display: none;">
            <?=$header?>
            </textarea>
                <button type="submit" class="btn btn-warning"><?=Icon::show('download')?> To EXCEL</button>
            </form>
        </div>
    </div>
    <?php
}
?>

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
<?php
if($excelDataAsalRujukan != '[]'){
    $header = [
        'Jenis',
        'Faskes',
        'Jml',
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
    <div class="row">
        <div class="col text-right">
            <form action="<?= Url::toRoute(['toexcel'])?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="namaFile" value="Asal Rujukan">
                <textarea name="excelData" style="display: none;">
            <?=$excelDataAsalRujukan?>
            </textarea>
                <textarea name="header" style="display: none;">
            <?=$header?>
            </textarea>
                <button type="submit" class="btn btn-warning"><?=Icon::show('download')?> To EXCEL</button>
            </form>
        </div>
    </div>
    <?php
}
?>

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
<?php
if($excelDataSmf != '[]'){
    $header = [
        'SMF',
        'Jml',
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
    <div class="row">
        <div class="col text-right">
            <form action="<?= Url::toRoute(['toexcel'])?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="namaFile" value="SMF SPRI">
                <textarea name="excelData" style="display: none;">
            <?=$excelDataSmf?>
            </textarea>
                <textarea name="header" style="display: none;">
            <?=$header?>
            </textarea>
                <button type="submit" class="btn btn-warning"><?=Icon::show('download')?> To EXCEL</button>
            </form>
        </div>
    </div>
    <?php
}
?>
