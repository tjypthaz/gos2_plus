<?php

use kartik\icons\Icon;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Master Pasien';
?>
<h1><?= Html::encode($this->title) ?></h1>
<form method="get" action="">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="">Nomer RM</label>
                <input type="text" name="noRm" value="<?=Yii::$app->request->get('noRm')?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Nomer KTP</label>
                <input type="text" name="noKtp" value="<?=Yii::$app->request->get('noKtp')?>" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="">Nama Pasien</label>
                <input type="text" name="namaPasien" value="<?=Yii::$app->request->get('namaPasien')?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Nomer BPJS</label>
                <input type="text" name="noBpjs" value="<?=Yii::$app->request->get('noBpjs')?>" class="form-control">
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="">Alamat</label>
                <input type="text" name="alamat" value="<?=Yii::$app->request->get('alamat')?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Nomer HP</label>
                <input type="text" name="noHp" value="<?=Yii::$app->request->get('noHp')?>" class="form-control">
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col text-right">
            <?=Html::button(Icon::show('search')." Cari Data",['class' => 'btn btn-success','type' => 'submit'])?>
        </div>
    </div>
</form>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'font-size:10px;'],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'NORM',
        'tglBuat',
        'NAMA',
        'tglLahir',
        'jnsKelamin',
        'ALAMAT',
        'noKtp',
        'noHp',
        'noBpjs',
    ],
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager'
    ]
]); ?>
