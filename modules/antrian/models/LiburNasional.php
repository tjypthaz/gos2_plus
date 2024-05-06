<?php

namespace app\modules\antrian\models;

use Yii;

/**
 * This is the model class for table "libur_nasional".
 *
 * @property int $ID
 * @property string|null $TANGGAL_LIBUR
 * @property string|null $KETERANGAN
 * @property string|null $TANGGAL
 * @property int|null $OLEH
 * @property int|null $STATUS
 */
class LiburNasional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libur_nasional';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_regonline');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TANGGAL_LIBUR', 'TANGGAL'], 'safe'],
            [['OLEH', 'STATUS'], 'integer'],
            [['KETERANGAN'], 'string', 'max' => 50],
            [['TANGGAL_LIBUR'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TANGGAL_LIBUR' => 'Tanggal Libur',
            'KETERANGAN' => 'Keterangan',
            'TANGGAL' => 'Tanggal',
            'OLEH' => 'Oleh',
            'STATUS' => 'Status',
        ];
    }
}
