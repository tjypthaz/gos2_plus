<?php

namespace app\modules\ihs\models;

use Yii;

/**
 * This is the model class for table "tindakan_to_loinc".
 *
 * @property int $TINDAKAN ID tindakan
 * @property int $LOINC_TERMINOLOGI loinc_terminologi id
 * @property int $SPESIMENT type_code_reference type = 52
 * @property int $KATEGORI type_code_reference type = 58
 * @property int $STATUS status
 */
class TindakanToLoinc extends \yii\db\ActiveRecord
{
    public $namaTindakan;
    public $namaLoinc;
    public $namaSpesimen;
    public $namaKategori;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tindakan_to_loinc';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_ihs');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TINDAKAN', 'LOINC_TERMINOLOGI'], 'required'],
            [['TINDAKAN', 'LOINC_TERMINOLOGI', 'SPESIMENT', 'KATEGORI', 'STATUS'], 'integer'],
            [['TINDAKAN', 'LOINC_TERMINOLOGI'], 'unique', 'targetAttribute' => ['TINDAKAN', 'LOINC_TERMINOLOGI']],
            [['TINDAKAN'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'TINDAKAN' => 'Tindakan',
            'LOINC_TERMINOLOGI' => 'Loinc Terminologi',
            'SPESIMENT' => 'Spesiment',
            'KATEGORI' => 'Kategori',
            'STATUS' => 'Status',
        ];
    }

}
