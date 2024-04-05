<?php

namespace app\modules\pembayaran\models;

use Yii;

/**
 * This is the model class for table "h2h".
 *
 * @property int $id
 * @property string $idTagihan
 * @property int $noRm
 * @property float $totalTagihan
 * @property float|null $bayar
 * @property string $status 1:new;2:lunas;3:batal
 * @property string $publish 1:publish;2:unPub
 * @property string|null $createBy
 * @property string|null $createDate
 * @property string|null $updateBy
 * @property string|null $updateDate
 */
class H2h extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'h2h';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pembayaran');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idTagihan', 'noRm', 'totalTagihan'], 'required'],
            [['noRm'], 'integer'],
            [['totalTagihan', 'bayar'], 'number'],
            [['createDate', 'updateDate'], 'safe'],
            [['idTagihan'], 'string', 'max' => 10],
            [['status', 'publish'], 'string', 'max' => 1],
            [['createBy', 'updateBy'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idTagihan' => 'Id Tagihan',
            'noRm' => 'No Rm',
            'totalTagihan' => 'Total Tagihan',
            'bayar' => 'Bayar',
            'status' => 'Status',
            'publish' => 'Publish',
            'createBy' => 'Create By',
            'createDate' => 'Create Date',
            'updateBy' => 'Update By',
            'updateDate' => 'Update Date',
        ];
    }
}
