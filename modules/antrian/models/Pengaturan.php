<?php

namespace app\modules\antrian\models;

use Yii;

/**
 * This is the model class for table "pengaturan".
 *
 * @property int $ID
 * @property int $LIMIT_DAFTAR Jml Max Pendaftar
 * @property int $DURASI Durasi Waktu Proses Per Pasien (Menit)
 * @property string $MULAI
 * @property string $BATAS_JAM_AMBIL
 * @property string $POS_ANTRIAN
 * @property int $STATUS
 * @property int $BATAS_MAX_HARI
 * @property int $BATAS_MAX_HARI_BPJS
 * @property int $MATAS_MAX_HARI_KONTROL
 * @property string|null $UPDATE_TIME
 */
class Pengaturan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengaturan';
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
            [['LIMIT_DAFTAR'], 'required'],
            [['LIMIT_DAFTAR', 'DURASI', 'STATUS', 'BATAS_MAX_HARI', 'BATAS_MAX_HARI_BPJS', 'MATAS_MAX_HARI_KONTROL'], 'integer'],
            [['MULAI', 'BATAS_JAM_AMBIL', 'UPDATE_TIME'], 'safe'],
            [['POS_ANTRIAN'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'LIMIT_DAFTAR' => 'Limit Daftar',
            'DURASI' => 'Durasi',
            'MULAI' => 'Mulai',
            'BATAS_JAM_AMBIL' => 'Batas Jam Ambil',
            'POS_ANTRIAN' => 'Pos Antrian',
            'STATUS' => 'Status',
            'BATAS_MAX_HARI' => 'Batas Max Hari',
            'BATAS_MAX_HARI_BPJS' => 'Batas Max Hari Bpjs',
            'MATAS_MAX_HARI_KONTROL' => 'Matas Max Hari Kontrol',
            'UPDATE_TIME' => 'Update Time',
        ];
    }
}
