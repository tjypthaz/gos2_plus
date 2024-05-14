<?php
/** @var yii\web\View $this */

use app\modules\jaspel\models\Jaspel;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Laporan Rekap Jaspel';
?>
<h1><?=$this->title?></h1>
<form action="" method="get" class="row mb-2">
    <div class="col">
        <?php
        $listRuangan = Yii::$app->db_jaspel
            ->createCommand("SELECT a.`ID`,a.`DESKRIPSI`
            FROM master.`ruangan` a
            WHERE a.`STATUS` = 1 AND a.`JENIS` = 5")
            ->queryAll();
        $listRuangan = ArrayHelper::map($listRuangan,'ID','DESKRIPSI');
        ?>
        <?= Html::dropDownList('idRuangan',Yii::$app->request->get('idRuangan'), $listRuangan,[
            'class' => 'form-control',
            'prompt' => 'Pilih Ruangan'
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
    <div class="col">
        <button type="submit" class="btn btn-outline-success">Tampilkan Data</button>
    </div>
</form>
<?php
if($excelData != '[]'){
    $header = [
        'Periode',
        'Unit',
        'Cara Bayar',
        'Dokter Operator',
        'Dokter Lainnya',
        'Jenis Paramedis',
        'Jp Dokter Operator',
        'Jp Dokter Lainnya',
        'Jp Paramedis',
        'Jp Akomodasi',
        'Jp Struktural',
        'Jp Blud',
        'Jp Pegawai',
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
        <div class="col text-right">
            <form action="<?= Url::toRoute(['toexcel'])?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="namaFile" value="Rekap Jaspel">
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
    //idDokter=44&idRuangan=102030101&idCaraBayar=2&bulan=2&tahun=2024&idPara=3
    [
        'attribute' => 'periode',
        'value' => function ($index){
            return Html::a($index['periode'],Url::to(['detail',
                'idDokter' => $index['idDokterO'],
                'idRuangan' => $index['idRuangan'],
                'idCaraBayar' => $index['idCaraBayar'],
                'bulan' => $index['bulan'],
                'tahun' => $index['tahun'],
                'idPara' => $index['idPara'],
            ]),[
                'target' => '_blank',
                'class' => 'btn btn-outline-success btn-sm',
            ]);
        },
        'format' => 'raw'
    ],
    //'periode',
    //'ruangan',
    [
        'attribute' => 'ruangan',
        'value' => function ($index){
            return $index['ruangan']."<br>".number_format($index['jpAkomodasi'],0,',','.');
        },
        'format' => 'html'
    ],
    [
        'attribute' => 'namaDokterO',
        'label' => 'Dokter O',
        'value' => function ($index){

            return $index['namaDokterO']."<br>".number_format($index['jpDokterO'],0,',','.');
        },
        'format' => 'html'
    ],
    [
        'attribute' => 'namaDokterL',
        'label' => 'Dokter L',
        'value' => function ($index){
            return $index['namaDokterL']."<br>".number_format($index['jpDokterL'],0,',','.');
        },
        'format' => 'html'
    ],
    [
        'attribute' => 'jenisPara',
        'label' => 'Paramedis',
        'value' => function ($index){
            return $index['jenisPara']."<br>".number_format($index['jpPara'],0,',','.');
        },
        'format' => 'html'
    ],
    'caraBayar',
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
