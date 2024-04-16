<?php

use app\modules\jaspel\models\Jaspel;
use kartik\select2\Select2;
use yii\bootstrap4\Dropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\grid\GridView;
/** @var yii\web\View $this */

$this->title = 'Data Tagihan RS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jaspel-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container mb-3">
        <form class="row" action="" method="get">
            <div class="col">
                <div class="form-group">
                    <label for="">Tanggal Daftar Dari</label>
                    <input type="date" name="tglAw" value="<?=Yii::$app->request->get('tglAw')?>" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Tanggal Daftar Hingga</label>
                    <input type="date" name="tglAk" value="<?=Yii::$app->request->get('tglAk')?>" class="form-control">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="">Nomor RM</label>
                    <input type="text" name="noRm" value="<?=Yii::$app->request->get('noRm')?>" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'idReg',
                'value' => function ($index){
                    return Html::a($index['idReg'],Url::to(['create',
                        'idTagihan' => $index['idTagihan'],
                        'noRM' => $index['noRm'],
                        'namaPasien' => $index['namaPasien'],
                    ]),[
                        'class' => 'btn btn-outline-success btn-sm',
                    ]);
                },
                'format' => 'raw'
            ],
            'noRm',
            'namaPasien',
            'tglDaftar',
            [
                'attribute' => 'tujuan',
                'label' => 'Asal',
                'value' => function ($index){
                    return $index['tujuan']."<br>".$index['noSep'];
                },
                'format' => 'html'
            ],
            'caraBayar',
            [
                'attribute' => 'kunci',
                'value' => function ($index){
                    return $index['kunci'] ? "Ya" : "Tidak";
                },
            ],
        ],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ]
    ]); ?>

</div>
