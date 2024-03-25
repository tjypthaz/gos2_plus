<?php

use app\modules\jaspel\models\Jaspel;
use kartik\select2\Select2;
use yii\bootstrap4\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
/** @var yii\web\View $this */

$this->title = 'Data Tagihan RS';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = "Periode Jaspel : ".Jaspel::getBulan(Yii::$app->session->get('bulan'))." ".Yii::$app->session->get('tahun');
?>
<div class="jaspel-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container mb-3">
        <form class="row" action="" method="get">
            <div class="col">
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
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
                    <?= \yii\bootstrap4\Html::dropDownList('caraBayar',Yii::$app->request->get('caraBayar'),$listCarabayar,[
                            'class' => 'form-control',
                        'prompt' => 'Pilih Cara Bayar'
                    ])
                    ?>
                </div>

            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="date" name="tglAk" value="<?=Yii::$app->request->get('tglAk')?>" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Nomor RM</label>
                    <input type="text" name="noRm" value="<?=Yii::$app->request->get('noRm')?>" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'noRm',
            'namaPasien',
            'tgl',
            [
                'attribute' => 'tujuan',
                'value' => function ($index){
                    return $index['tujuan']."<br>".$index['noSep'];
                },
                'format' => 'html'
            ],
            'caraBayar',
            [
                'attribute' => 'tagihanRs',
                'value' => function ($index){
                    return number_format($index['tagihanRs'],0,',','.');
                },
            ],
            [
                'attribute' => 'klaim',
                'value' => function ($index){
                    return number_format($index['klaim'],0,',','.');
                },
            ],
            'periode',
            [
                'attribute' => 'idReg',
                'label' => 'Action',
                'value' => function ($index){

                    return Html::a('Detail',Url::to(['detail-tagihan',
                            'idReg' => $index['idReg']
                            ]),[
                                'target' => '_blank',
                                'class' => 'btn btn-outline-success btn-sm',
                            ]);
                },
                'format' => 'raw'
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>

</div>
