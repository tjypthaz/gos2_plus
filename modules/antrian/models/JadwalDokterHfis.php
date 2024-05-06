<?php

namespace app\modules\antrian\models;

use Yii;

/**
 * This is the model class for table "jadwal_dokter_hfis".
 *
 * @property int $ID
 * @property string $KD_DOKTER
 * @property string $NM_DOKTER
 * @property string $KD_SUB_SPESIALIS
 * @property string $KD_POLI
 * @property int $HARI
 * @property string|null $TANGGAL
 * @property string $NM_HARI
 * @property string $JAM
 * @property string|null $JAM_MULAI
 * @property string|null $JAM_SELESAI
 * @property int|null $KAPASITAS
 * @property int|null $KOUTA_JKN
 * @property int|null $KOUTA_NON_JKN
 * @property int|null $LIBUR
 * @property int|null $STATUS
 * @property string|null $INPUT_TIME
 * @property string|null $UPDATE_TIME
 */
class JadwalDokterHfis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jadwal_dokter_hfis';
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
            [['KD_DOKTER', 'NM_DOKTER', 'KD_SUB_SPESIALIS', 'KD_POLI', 'HARI', 'NM_HARI', 'JAM'], 'required'],
            [['HARI', 'KAPASITAS', 'KOUTA_JKN', 'KOUTA_NON_JKN', 'LIBUR', 'STATUS'], 'integer'],
            [['TANGGAL', 'JAM_MULAI', 'JAM_SELESAI', 'INPUT_TIME', 'UPDATE_TIME'], 'safe'],
            [['KD_DOKTER', 'KD_SUB_SPESIALIS', 'KD_POLI', 'NM_HARI'], 'string', 'max' => 25],
            [['NM_DOKTER'], 'string', 'max' => 250],
            [['JAM'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_DOKTER' => 'Kd Dokter',
            'NM_DOKTER' => 'Nm Dokter',
            'KD_SUB_SPESIALIS' => 'Kd Sub Spesialis',
            'KD_POLI' => 'Kd Poli',
            'HARI' => 'Hari',
            'TANGGAL' => 'Tanggal',
            'NM_HARI' => 'Nm Hari',
            'JAM' => 'Jam',
            'JAM_MULAI' => 'Jam Mulai',
            'JAM_SELESAI' => 'Jam Selesai',
            'KAPASITAS' => 'Kapasitas',
            'KOUTA_JKN' => 'Kouta Jkn',
            'KOUTA_NON_JKN' => 'Kouta Non Jkn',
            'LIBUR' => 'Libur',
            'STATUS' => 'Status',
            'INPUT_TIME' => 'Input Time',
            'UPDATE_TIME' => 'Update Time',
        ];
    }
}
