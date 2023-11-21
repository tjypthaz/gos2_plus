<?php

namespace app\modules\lis\models;

use Yii;

/**
 * This is the model class for table "mapping_hasil".
 *
 * @property int $ID
 * @property int $VENDOR_LIS
 * @property string $LIS_KODE_TEST
 * @property string $PREFIX_KODE
 * @property int $HIS_KODE_TEST
 * @property int $PARAMETER_TINDAKAN_LAB
 */
class MappingHasil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mapping_hasil';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_lis');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['VENDOR_LIS', 'LIS_KODE_TEST', 'HIS_KODE_TEST', 'PARAMETER_TINDAKAN_LAB'], 'required'],
            [['VENDOR_LIS', 'HIS_KODE_TEST', 'PARAMETER_TINDAKAN_LAB'], 'integer'],
            [['LIS_KODE_TEST'], 'string', 'max' => 50],
            [['PREFIX_KODE'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'VENDOR_LIS' => 'Vendor Lis',
            'LIS_KODE_TEST' => 'Lis Kode Test',
            'PREFIX_KODE' => 'Prefix Kode',
            'HIS_KODE_TEST' => 'His Kode Test',
            'PARAMETER_TINDAKAN_LAB' => 'Parameter Tindakan Lab',
        ];
    }
}
