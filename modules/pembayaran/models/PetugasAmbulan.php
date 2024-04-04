<?php

namespace app\modules\pembayaran\models;

use Yii;

/**
 * This is the model class for table "petugas_ambulan".
 *
 * @property int $id
 * @property int $idTagihanAmbulan
 * @property int $idPegawai
 * @property string $publish
 * @property string|null $createDate
 * @property string|null $createBy
 * @property string|null $updateDate
 * @property string|null $updateBy
 *
 * @property TagihanAmbulan $idTagihanAmbulan0
 */
class PetugasAmbulan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'petugas_ambulan';
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
            [['idTagihanAmbulan', 'idPegawai'], 'required'],
            [['idTagihanAmbulan', 'idPegawai'], 'integer'],
            [['createDate', 'updateDate'], 'safe'],
            [['publish'], 'string', 'max' => 1],
            [['createBy', 'updateBy'], 'string', 'max' => 30],
            [['idTagihanAmbulan'], 'exist', 'skipOnError' => true, 'targetClass' => TagihanAmbulan::class, 'targetAttribute' => ['idTagihanAmbulan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idTagihanAmbulan' => 'Id Tagihan Ambulan',
            'idPegawai' => 'Pegawai',
            'publish' => 'Publish',
            'createDate' => 'Create Date',
            'createBy' => 'Create By',
            'updateDate' => 'Update Date',
            'updateBy' => 'Update By',
        ];
    }

    /**
     * Gets query for [[IdTagihanAmbulan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdTagihanAmbulan0()
    {
        return $this->hasOne(TagihanAmbulan::class, ['id' => 'idTagihanAmbulan']);
    }
}