<?php
/** @var yii\web\View $this */

use app\modules\jaspel\models\Jaspel;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Laporan Klaim Jaspel';
?>
<h1><?=$this->title?></h1>
<form action="" method="get" class="row mb-2">
    <div class="col">
        <?php
        $listCarabayar = Yii::$app->db_jaspel
            ->createCommand("SELECT * FROM `master`.`referensi` WHERE JENIS=10 AND `STATUS` = 1")
            ->queryAll();
        $listCarabayar = ArrayHelper::map($listCarabayar,'ID','DESKRIPSI');
        ?>
        <?= Html::dropDownList('caraBayar',Yii::$app->request->get('caraBayar'),$listCarabayar,[
            'class' => 'form-control',
            'prompt' => 'Pilih Cara Bayar'
        ])
        ?>
    </div>
    <div class="col">
        <?= Html::dropDownList('bulan',Yii::$app->request->get('bulan'), Jaspel::getBulan(),[
            'class' => 'form-control',
            'prompt' => 'Pilih Bulan',
            'required' => 'required'
        ])
        ?>
    </div>
    <div class="col">
        <?= Html::dropDownList('tahun',Yii::$app->request->get('tahun'), Jaspel::getTahun(),[
            'class' => 'form-control',
            'prompt' => 'Pilih Tahun',
            'required' => 'required'
        ])
        ?>
    </div>
    <div class="col text-right">
        <button type="submit" class="btn btn-outline-success">Tampilkan Data</button>
    </div>
</form>
<?php
if($excelData != '[]'){
    $header = [
        'idReg',
        'tgl',
        'noRm',
        'namaPasien',
        'caraBayar',
        'tagihanRs',
        'klaim',
        'klaimKronis',
        'labaRugi',
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
        <div class="col text-right">
            <form action="<?= Url::toRoute(['toexcel'])?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="namaFile" value="<?=$this->title?>">
                <textarea name="excelData" style="display: none;">
                <?=$excelData?>
                </textarea>
                <textarea name="header" style="display: none;">
                <?=$header?>
                </textarea>
                <input type="submit" class="btn btn-outline-warning" value="Export EXCEL"  />
            </form>
        </div>

    <?php
}
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'idReg',
    'tgl',
    'noRm',
    'namaPasien',
    'caraBayar',
    [
            'attribute' => 'tagihanRs',
        'value' => function($index){
            return number_format($index['tagihanRs'],'0',',','.') ;
        }
    ],
    [
        'attribute' => 'klaim',
        'value' => function($index){
            return number_format($index['klaim'],'0',',','.') ;
        }
    ],
    [
        'attribute' => 'klaimKronis',
        'value' => function($index){
            return number_format($index['klaimKronis'],'0',',','.') ;
        }
    ],
    [
        'attribute' => 'labaRugi',
        'value' => function($index){
            return number_format($index['labaRugi'],'0',',','.') ;
        }
    ],
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>

<div class="row">
    <div class="col text-right">
        <h1>Total Laba / Rugi : <?=number_format($totalLabaRugi,'0',',','.')?></h1>
    </div>

</div>

