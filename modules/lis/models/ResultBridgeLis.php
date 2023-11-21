<?php

namespace app\modules\lis\models;

use Yii;

/**
 * This is the model class for table "result_bridge_lis".
 *
 * @property string $lis_reg_no
 * @property string $lis_test_id
 * @property string|null $his_reg_no
 * @property string|null $test_name
 * @property string|null $result
 * @property string|null $result_comment
 * @property string|null $reference_value
 * @property string|null $reference_note
 * @property string|null $test_flag_sign
 * @property string|null $test_unit_name
 * @property string|null $instrument_name
 * @property string|null $authorization_date
 * @property string|null $authorization_user
 * @property string|null $greaterthan_value
 * @property string|null $lessthan_value
 * @property string|null $company_id
 * @property string|null $agreement_id
 * @property string|null $age_year
 * @property string|null $age_month
 * @property string|null $age_days
 * @property string|null $his_test_id_order
 * @property int|null $transfer_flag
 *
 * @property Registration $hisRegNo
 */
class ResultBridgeLis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'result_bridge_lis';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_lis_bridging');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lis_reg_no', 'lis_test_id'], 'required'],
            [['result', 'result_comment', 'reference_value', 'reference_note'], 'string'],
            [['authorization_date'], 'safe'],
            [['transfer_flag'], 'integer'],
            [['lis_reg_no', 'company_id', 'agreement_id'], 'string', 'max' => 10],
            [['lis_test_id', 'test_unit_name'], 'string', 'max' => 25],
            [['his_reg_no', 'test_name', 'instrument_name', 'authorization_user', 'greaterthan_value', 'lessthan_value', 'his_test_id_order'], 'string', 'max' => 50],
            [['test_flag_sign'], 'string', 'max' => 5],
            [['age_year'], 'string', 'max' => 3],
            [['age_month', 'age_days'], 'string', 'max' => 2],
            [['lis_reg_no', 'lis_test_id'], 'unique', 'targetAttribute' => ['lis_reg_no', 'lis_test_id']],
            [['his_reg_no'], 'exist', 'skipOnError' => true, 'targetClass' => Registration::class, 'targetAttribute' => ['his_reg_no' => 'order_number']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lis_reg_no' => 'Lis Reg No',
            'lis_test_id' => 'Lis Test ID',
            'his_reg_no' => 'His Reg No',
            'test_name' => 'Test Name',
            'result' => 'Result',
            'result_comment' => 'Result Comment',
            'reference_value' => 'Reference Value',
            'reference_note' => 'Reference Note',
            'test_flag_sign' => 'Test Flag Sign',
            'test_unit_name' => 'Test Unit Name',
            'instrument_name' => 'Instrument Name',
            'authorization_date' => 'Authorization Date',
            'authorization_user' => 'Authorization User',
            'greaterthan_value' => 'Greaterthan Value',
            'lessthan_value' => 'Lessthan Value',
            'company_id' => 'Company ID',
            'agreement_id' => 'Agreement ID',
            'age_year' => 'Age Year',
            'age_month' => 'Age Month',
            'age_days' => 'Age Days',
            'his_test_id_order' => 'His Test Id Order',
            'transfer_flag' => 'Transfer Flag',
        ];
    }

    /**
     * Gets query for [[HisRegNo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHisRegNo()
    {
        return $this->hasOne(Registration::class, ['order_number' => 'his_reg_no']);
    }
}
