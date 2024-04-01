<?php

namespace app\modules\pembayaran\models;

use Yii;

/**
 * This is the model class for table "jenis_ambulan".
 *
 * @property int $id
 * @property string $deskripsi
 * @property int $jsProp
 * @property int $jpProp
 * @property float $hargaPerKM
 * @property string $publish
 * @property string|null $createDate
 * @property string|null $createBy
 * @property string|null $updateDate
 * @property string|null $updateBy
 *
 * @property TagihanAmbulan[] $tagihanAmbulans
 */
class JenisAmbulan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_ambulan';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_pembayaran');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['deskripsi', 'jsProp', 'jpProp', 'hargaPerKM'], 'required'],
            [['jsProp', 'jpProp'], 'integer'],
            [['hargaPerKM'], 'number'],
            [['createDate', 'updateDate'], 'safe'],
            [['deskripsi'], 'string', 'max' => 35],
            [['publish'], 'string', 'max' => 1],
            [['createBy', 'updateBy'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deskripsi' => 'Deskripsi',
            'jsProp' => 'Js Prop',
            'jpProp' => 'Jp Prop',
            'hargaPerKM' => 'Harga Per Km',
            'publish' => 'Publish',
            'createDate' => 'Create Date',
            'createBy' => 'Create By',
            'updateDate' => 'Update Date',
            'updateBy' => 'Update By',
        ];
    }

    /**
     * Gets query for [[TagihanAmbulans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagihanAmbulans()
    {
        return $this->hasMany(TagihanAmbulan::class, ['idJenisAmbulan' => 'id']);
    }
}
