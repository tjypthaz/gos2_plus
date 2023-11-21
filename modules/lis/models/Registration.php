<?php

namespace app\modules\lis\models;

use Yii;

/**
 * This is the model class for table "registration".
 *
 * @property string $patient_id
 * @property string $visit_number
 * @property string $order_number
 * @property string $order_datetime
 * @property string|null $diagnose_id
 * @property string|null $diagnose_name
 * @property string $service_unit_id
 * @property string $service_unit_name
 * @property string|null $guarantor_id
 * @property string|null $guarantor_name
 * @property int|null $agreement_id
 * @property string|null $agreement_name
 * @property string|null $doctor_id
 * @property string|null $doctor_name
 * @property string|null $class_id
 * @property string|null $class_name
 * @property string|null $ward_id
 * @property string|null $ward_name
 * @property string|null $room_id
 * @property string|null $room_name
 * @property string|null $bed_id
 * @property string|null $bed_name
 * @property string|null $reg_user_id
 * @property string|null $reg_user_name
 * @property string|null $lis_reg_no
 * @property string|null $retrieved_dt
 * @property string|null $retrieved_flag
 *
 * @property OrderedItem[] $orderedItems
 * @property Demographic $patient
 * @property ResultBridgeLis[] $resultBridgeLis
 */
class Registration extends \yii\db\ActiveRecord
{

    public $patient_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'registration';
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
            [['patient_id', 'visit_number', 'order_number', 'order_datetime', 'service_unit_id', 'service_unit_name'], 'required'],
            [['order_datetime', 'retrieved_dt'], 'safe'],
            [['agreement_id'], 'integer'],
            [['agreement_name'], 'string'],
            [['patient_id', 'visit_number', 'order_number', 'diagnose_id', 'service_unit_id', 'guarantor_id', 'guarantor_name', 'doctor_id', 'doctor_name', 'class_id', 'class_name', 'ward_id', 'ward_name', 'room_id', 'room_name', 'bed_id', 'bed_name', 'reg_user_name'], 'string', 'max' => 50],
            [['diagnose_name', 'service_unit_name'], 'string', 'max' => 255],
            [['reg_user_id', 'lis_reg_no'], 'string', 'max' => 20],
            [['retrieved_flag'], 'string', 'max' => 1],
            [['order_number'], 'unique'],
            [['patient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Demographic::class, 'targetAttribute' => ['patient_id' => 'patient_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'patient_id' => 'Patient ID',
            'visit_number' => 'Visit Number',
            'order_number' => 'Order Number',
            'order_datetime' => 'Order Datetime',
            'diagnose_id' => 'Diagnose ID',
            'diagnose_name' => 'Diagnose Name',
            'service_unit_id' => 'Service Unit ID',
            'service_unit_name' => 'Service Unit Name',
            'guarantor_id' => 'Guarantor ID',
            'guarantor_name' => 'Guarantor Name',
            'agreement_id' => 'Agreement ID',
            'agreement_name' => 'Agreement Name',
            'doctor_id' => 'Doctor ID',
            'doctor_name' => 'Doctor Name',
            'class_id' => 'Class ID',
            'class_name' => 'Class Name',
            'ward_id' => 'Ward ID',
            'ward_name' => 'Ward Name',
            'room_id' => 'Room ID',
            'room_name' => 'Room Name',
            'bed_id' => 'Bed ID',
            'bed_name' => 'Bed Name',
            'reg_user_id' => 'Reg User ID',
            'reg_user_name' => 'Reg User Name',
            'lis_reg_no' => 'Lis Reg No',
            'retrieved_dt' => 'Retrieved Dt',
            'retrieved_flag' => 'Retrieved Flag',
        ];
    }

    /**
     * Gets query for [[OrderedItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderedItems()
    {
        return $this->hasMany(OrderedItem::class, ['order_number' => 'order_number']);
    }

    /**
     * Gets query for [[Patient]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPatient()
    {
        return $this->hasOne(Demographic::class, ['patient_id' => 'patient_id']);
    }

    /**
     * Gets query for [[ResultBridgeLis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResultBridgeLis()
    {
        return $this->hasMany(ResultBridgeLis::class, ['his_reg_no' => 'order_number']);
    }
}
