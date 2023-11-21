<?php

namespace app\modules\lis\models;

use Yii;

/**
 * This is the model class for table "demographics".
 *
 * @property string $patient_id
 * @property string $gender_id
 * @property string $gender_name
 * @property string $date_of_birth
 * @property string $patient_name
 * @property string|null $patient_address
 * @property string|null $city_id
 * @property string|null $city_name
 * @property string|null $phone_number
 * @property string|null $fax_number
 * @property string|null $mobile_number
 * @property string|null $email
 *
 * @property Registration[] $registrations
 */
class Demographic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'demographics';
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
            [['patient_id', 'gender_id', 'gender_name', 'date_of_birth', 'patient_name'], 'required'],
            [['date_of_birth'], 'safe'],
            [['patient_address'], 'string'],
            [['patient_id', 'gender_name', 'city_id', 'city_name', 'phone_number', 'fax_number', 'mobile_number'], 'string', 'max' => 50],
            [['gender_id'], 'string', 'max' => 10],
            [['patient_name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['patient_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'patient_id' => 'Patient ID',
            'gender_id' => 'Gender ID',
            'gender_name' => 'Gender Name',
            'date_of_birth' => 'Date Of Birth',
            'patient_name' => 'Patient Name',
            'patient_address' => 'Patient Address',
            'city_id' => 'City ID',
            'city_name' => 'City Name',
            'phone_number' => 'Phone Number',
            'fax_number' => 'Fax Number',
            'mobile_number' => 'Mobile Number',
            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[Registrations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegistrations()
    {
        return $this->hasMany(Registration::class, ['patient_id' => 'patient_id']);
    }
}
