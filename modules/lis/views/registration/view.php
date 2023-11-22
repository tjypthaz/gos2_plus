<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\lis\models\Registration $model */

$this->title = "Detail : ".$model->order_number;
$this->params['breadcrumbs'][] = ['label' => 'Bridging', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="registration-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'patient_id',
            'visit_number',
            'order_number',
            'order_datetime',
            //'diagnose_id',
            'diagnose_name',
            //'service_unit_id',
            'service_unit_name',
            'guarantor_id',
            //'guarantor_name',
            //'agreement_id',
            //'agreement_name:ntext',
            //'doctor_id',
            'doctor_name',
            //'class_id',
            //'class_name',
            //'ward_id',
            'ward_name',
            //'room_id',
            'room_name',
            //'bed_id',
            'bed_name',
            //'reg_user_id',
            //'reg_user_name',
            'lis_reg_no',
            //'retrieved_dt',
            //'retrieved_flag',
        ],
    ]) ?>

    <?php
    if(count($model->orderedItems) > 0){
        ?>
        <h2>Order Pemeriksaan</h2>
        <table class="table table-striped table-hover">
            <tr>
                <td>#</td>
                <td>Kode Pemeriksaan</td>
                <td>Nama Pemeriksaan</td>
                <td>Order Time</td>
                <td>Status</td>
            </tr>
            <?php
            $i=1;
            foreach ($model->orderedItems as $item){
                ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$item['order_item_id']?></td>
                    <td><?=$item['order_item_name']?></td>
                    <td><?=$item['order_item_datetime']?></td>
                    <td><?=$item['order_status']?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </table>
        <?php
    }

    if(count($model->resultBridgeLis) > 0){
        ?>
        <h2>Hasil Pemeriksaan</h2>
        <table class="table table-striped table-hover">
            <tr>
                <td>#</td>
                <td>Kode Pemeriksaan</td>
                <td>Nama Pemeriksaan</td>
                <td>Hasil</td>
                <td>Nilai Rujukan</td>
                <td>Is Transfer</td>
            </tr>
            <?php
            $i=1;
            foreach ($model->resultBridgeLis as $item){
                ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=$item['lis_test_id']?></td>
                    <td><?=$item['test_name']?></td>
                    <td><?=$item['result']?></td>
                    <td><?=$item['reference_value']." (".$item['test_unit_name'].")"?></td>
                    <td><?=$item['transfer_flag']?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </table>
        <?php
    }

    ?>

</div>
