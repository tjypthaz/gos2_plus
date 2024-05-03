<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Laporan Pasien Ranap';
?>
<h1><?= Html::encode($this->title) ?></h1>
<form class="row" method="get" action="">
    <div class="col">
        <div class="form-group">
            <label for="">Tanggal Masuk Awal</label>
            <input type="date" name="tglAw" value="<?=Yii::$app->request->get('tglAw')?>" class="form-control">
        </div>
        <?php
        $listCarabayar = Yii::$app->db_jaspel
            ->createCommand("SELECT * FROM `master`.`referensi` WHERE JENIS=10 AND `STATUS` = 1")
            ->queryAll();
        $listCarabayar = ArrayHelper::map($listCarabayar,'ID','DESKRIPSI');
        ?>
        <div class="form-group">
            <label for="">Cara Bayar</label>
            <?= Html::dropDownList('caraBayar',Yii::$app->request->get('caraBayar'),$listCarabayar,[
                'class' => 'form-control',
                'prompt' => 'Pilih Cara Bayar'
            ])
            ?>
        </div>
        <div class="form-group">
            <label for="">Alamat</label>
            <input type="text" name="alamat" value="<?=Yii::$app->request->get('alamat')?>" class="form-control">
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="">Tanggal Masuk Akhir</label>
            <input type="date" name="tglAk" value="<?=Yii::$app->request->get('tglAk')?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Nomer RM</label>
            <input type="text" name="noRm" value="<?=Yii::$app->request->get('noRm')?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Belum ada SEP</label>
            <?=SwitchInput::widget(['name'=>'isSep', 'value' => Yii::$app->request->get('isSep') ? true : false]);?>
        </div>
    </div>
    <div class="col">
        <?php
        $listRuangan = Yii::$app->db_jaspel
            ->createCommand("SELECT * FROM `master`.`ruangan` WHERE JENIS=5 and JENIS_KUNJUNGAN=3 AND `STATUS` = 1 order by ID asc")
            ->queryAll();
        $listRuangan = ArrayHelper::map($listRuangan,'ID','DESKRIPSI');
        ?>
        <div class="form-group">
            <label for="">Ruangan</label>
            <?= Html::dropDownList('ruangan',Yii::$app->request->get('ruangan'),$listRuangan,[
                'class' => 'form-control',
                'prompt' => 'Pilih Ruangan'
            ])
            ?>
        </div>
        <div class="form-group">
            <label for="">Nama Pasien</label>
            <input type="text" name="namaPasien" value="<?=Yii::$app->request->get('namaPasien')?>" class="form-control">
        </div>
        <div class="form-group">
            <br>
            <?=Html::button(Icon::show('search')." Cari Data",['class' => 'btn btn-success','type' => 'submit'])?>
        </div>
    </div>
</form>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'NORM',
            'value' => function ($index){
                return $index['NORM']."<br>".$index['NAMA']."<br>".$index['ALAMAT'];
            },
            'format' => 'html'
        ],
        [
            'attribute' => 'RUANGAN',
            'value' => function ($index){
                return $index['RUANGAN']." (".$index['TEMPAT_TIDUR'].")"."<br>".$index['MASUK'];
            },
            'format' => 'html'
        ],
        [
            'attribute' => 'caraBayar',
            'value' => function ($index){
                return $index['caraBayar'];
            },
            'format' => 'html'
        ],
        'noSep',
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
