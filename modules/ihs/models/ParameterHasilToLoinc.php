<?php

namespace app\modules\ihs\models;

use Yii;

/**
 * This is the model class for table "parameter_hasil_to_loinc".
 *
 * @property int $PARAMETER_HASIL parameter tindakan lab
 * @property int|null $LOINC_TERMINOLOGI
 * @property int $STATUS
 */
class ParameterHasilToLoinc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parameter_hasil_to_loinc';
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
            [['PARAMETER_HASIL'], 'required'],
            [['PARAMETER_HASIL', 'LOINC_TERMINOLOGI', 'STATUS'], 'integer'],
            [['PARAMETER_HASIL', 'LOINC_TERMINOLOGI'], 'unique', 'targetAttribute' => ['PARAMETER_HASIL', 'LOINC_TERMINOLOGI']],
            [['PARAMETER_HASIL'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'PARAMETER_HASIL' => 'Parameter Hasil',
            'LOINC_TERMINOLOGI' => 'Loinc Terminologi',
            'STATUS' => 'Status',
        ];
    }
}
