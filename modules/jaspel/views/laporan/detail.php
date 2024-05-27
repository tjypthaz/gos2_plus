<?php
/** @var yii\web\View $this */

use app\modules\jaspel\models\Jaspel;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Laporan Detail Jaspel Final';
?>
<h1><?=$this->title?></h1>

<form action="" method="get" class="mb-2">
    <div class="row mb-2">
        <div class="col">
            <?= Html::dropDownList('idDokter',Yii::$app->request->get('idDokter'), $listDokter,[
                'class' => 'form-control',
                'prompt' => 'Pilih Dokter'
            ])
            ?>
        </div>
        <div class="col">
            <?= Html::dropDownList('idRuangan',Yii::$app->request->get('idRuangan'), $listRuangan,[
                'class' => 'form-control',
                'prompt' => 'Pilih Ruangan'
            ])
            ?>
        </div>
        <div class="col">
            <?= Html::dropDownList('idCaraBayar',Yii::$app->request->get('idCaraBayar'), $listCarabayar,[
                'class' => 'form-control',
                'prompt' => 'Pilih Cara Bayar'
            ])
            ?>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <?= Html::dropDownList('bulan',Yii::$app->request->get('bulan'), Jaspel::getBulan(),[
                'class' => 'form-control',
                'prompt' => 'Pilih Bulan'
            ])
            ?>
        </div>
        <div class="col">
            <?= Html::dropDownList('tahun',Yii::$app->request->get('tahun'), Jaspel::getTahun(),[
                'class' => 'form-control',
                'prompt' => 'Pilih Tahun'
            ])
            ?>
        </div>
        <div class="col">
            <?= Html::dropDownList('idPara',Yii::$app->request->get('idPara'), $listJenisPara,[
                'class' => 'form-control',
                'prompt' => 'Pilih Paramedis'
            ])
            ?>

        </div>
    </div>
    <button type="submit" class="btn btn-outline-success">Tampilkan Data</button>
</form>
<?php
if($excelData != '[]'){
    $header = [
        'Id Final',
        'Periode',
        'Tgl Daftar',
        'No RM',
        'Nama Pasien',
        'Unit',
        'Cara Bayar',
        'Dokter Operator',
        'Dokter Lainnya',
        'Tindakan',
        'Jp Dokter Operator',
        'Jp Dokter Lainnya',
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
        <div class="col text-right">
            <form action="<?= Url::toRoute(['toexcel'])?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="namaFile" value="Detail Jaspel">
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
Yii::$app->user->setReturnUrl(Url::current());
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'id',
        'value' => function ($index){
            return Html::a($index['id'],'#',[
                //'target' => '_blank',
                'class' => 'btn btn-outline-success btn-sm modalButton',
                'value' => Url::to(['/jaspel/jaspel-final/update',
                    'id' => $index['id'],
                ])
            ]);
        },
        'format' => 'raw'
    ],
    //'id',
    'periode',
    'tglDaftar',
    [
        'attribute' => 'noRm',
        'value' => function ($index){
            return Html::a($index['noRm'],Url::to(['/jaspel/tagihan/jaspel-final',
                'id' => $index['idJaspel'],
            ]),[
                'target' => '_blank',
                'class' => 'btn btn-outline-success btn-sm'
            ]);
        },
        'format' => 'raw'
    ],
    'namaPasien',
    [
        'attribute' => 'ruangan',
        'value' => function ($index){
            return $index['ruangan']."<br>".number_format($index['jpAkomodasi'],0,',','.');
        },
        'format' => 'html'
    ],
    //'ruangan',
    'caraBayar',
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
    'tindakan',
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>

<?php
Modal::begin([
    //'header' => 'Modal',
    'id' => 'modal',
    'size' => 'modal-md',
]);
echo "<div id='modalContent'></div>";
Modal::end();
?>

<?php
$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
?>