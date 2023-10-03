<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vendor_lis".
 *
 * @property int $ID
 * @property string $NAMA
 * @property string|null $NAMA_SCHEDULER
 * @property int $STATUS
 */
class VendorLis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vendor_lis';
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
            [['NAMA'], 'required'],
            [['STATUS'], 'integer'],
            [['NAMA', 'NAMA_SCHEDULER'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NAMA' => 'Nama',
            'NAMA_SCHEDULER' => 'Nama Scheduler',
            'STATUS' => 'Status',
        ];
    }
}
