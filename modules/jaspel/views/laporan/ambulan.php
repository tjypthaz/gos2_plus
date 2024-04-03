<?php
/** @var yii\web\View $this */

use app\modules\jaspel\models\Jaspel;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Laporan Rekap Jaspel Ambulan';
?>
<h1><?=$this->title?></h1>

<form action="" method="get" class="mb-2">
    <div class="row mb-2">
        <div class="col">
            <input type="date" name="tglAw" value="<?=Yii::$app->request->get('tglAw')?>" class="form-control">
        </div>
        <div class="col">
            <input type="date" name="tglAk" value="<?=Yii::$app->request->get('tglAk')?>" class="form-control">
        </div>
    </div>
    <button type="submit" class="btn btn-outline-success">Tampilkan Data</button>
</form>
<?php
if($excelData != '[]'){
    $header = [
        'Nama Pegawai',
        'JPL',
        'JPTL',
    ];
    $header = htmlspecialchars(Json::encode($header));
    ?>
        <div class="col text-right">
            <form action="<?= Url::toRoute(['toexcel'])?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="namaFile" value="Jaspel Ambulan">
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
    'namaPegawai',
    'jpl',
    'jptl',
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
