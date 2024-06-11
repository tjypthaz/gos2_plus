<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\ihs\models\TindakanToLoinc $model */

$this->title = $model->TINDAKAN;
$this->params['breadcrumbs'][] = ['label' => 'Laboratorium Mapping Loinc', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

Yii::$app->user->setReturnUrl(Url::current());
?>
<div class="tindakan-to-loinc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'TINDAKAN' => $model->TINDAKAN], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'TINDAKAN' => $model->TINDAKAN], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'namaTindakan',
                'value' => function($model){
                    return Yii::$app->db_ihs
                        ->createCommand("select NAMA from master.tindakan where ID = :id")
                        ->bindValue(':id',$model->TINDAKAN)->queryScalar();
                }
            ],
            [
                'attribute' => 'namaLoinc',
                'value' => function($model){
                    return Yii::$app->db_ihs
                        ->createCommand("
                        select concat(Kategori_pemeriksaan,'-<b>',nama_pemeriksaan,'</b><br>',code,'-',display) 
                        from `kemkes-ihs`.`loinc_terminologi` 
                        where id=:id")
                        ->bindValue(':id',$model->LOINC_TERMINOLOGI)->queryScalar();
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'namaSpesimen',
                'value' => function($model){
                    return Yii::$app->db_ihs
                        ->createCommand("select display from `kemkes-ihs`.`type_code_reference` where type = 52 and id=:id")
                        ->bindValue(':id',$model->SPESIMENT)->queryScalar();
                }
            ],
            [
                'attribute' => 'namaKategori',
                'value' => function($model){
                    return Yii::$app->db_ihs
                        ->createCommand("select display from `kemkes-ihs`.`type_code_reference` where type = 58 and id=:id")
                        ->bindValue(':id',$model->KATEGORI)->queryScalar();
                }
            ],
        ],
    ]) ?>

    <h1>Parameter Hasil</h1>
    <?php
    $listParameter = Yii::$app->db_ihs->createCommand("
        select a.ID,a.PARAMETER,concat(c.Kategori_pemeriksaan,'-<b>',c.nama_pemeriksaan,'</b><br>',c.code,'-',c.display) loinc
        from master.parameter_tindakan_lab a
        left join `kemkes-ihs`.parameter_hasil_to_loinc b on b.PARAMETER_HASIL = a.ID
        left join `kemkes-ihs`.loinc_terminologi c on c.id = b.LOINC_TERMINOLOGI
        where a.STATUS = 1 and a.TINDAKAN = ".$model->TINDAKAN."
    ")->queryAll();
    if($listParameter){
        ?>
        <table class="table">
            <tr>
                <td>Id Parameter</td>
                <td>Nama Parameter</td>
                <td>Loinc Terminologi</td>
                <td>&nbsp</td>
            </tr>
        <?php
        foreach ($listParameter as $item){
            ?>
            <tr>
                <td><?=$item['ID']?></td>
                <td><?=$item['PARAMETER']?></td>
                <td><?=$item['loinc']?></td>
                <td>
                    <?=$item['loinc'] ?
                        \yii\bootstrap4\Html::a('Hapus Mapping Hasil',[
                                '/ihs/mapping-hasillab/delete',
                            'PARAMETER_HASIL' => $item['ID']
                        ],['class' => 'btn btn-danger btn-sm','data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],]):
                        \yii\bootstrap4\Html::a(
                                'Buat Mapping Hasil',
                                '#',
                                [
                                        'class' => 'btn btn-success btn-sm modalButton',
                                    'value' => Url::to(['/ihs/mapping-hasillab/create','ID' => $item['ID']])
                                ]);
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
        </table>
        <?php
    }else{
        echo 'Tidak ada parameter hasil';
    }
    ?>

</div>

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
