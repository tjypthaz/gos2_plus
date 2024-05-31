<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Laporan Rekap Kunjungan';
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

<h3>Kunjungan Rajal : Poli, IGD, Laboratorium, Radiologi, Hemodialisa ( <?=$totalPasien?> )</h3>
<?= GridView::widget([
    'dataProvider' => $dataProviderAsalRujukan,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'asalRujukan',
        'jumlah'
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProviderJenisKunjungan,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'jenisKunjungan',
        'jumlah'
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
