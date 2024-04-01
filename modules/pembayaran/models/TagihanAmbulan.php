<?php

namespace app\modules\pembayaran\models;

use Yii;

/**
 * This is the model class for table "tagihan_ambulan".
 *
 * @property int $id
 * @property int $idJenisAmbulan
 * @property int $idTagihan tagihan di simgos harus FINAL
 * @property string $tanggal
 * @property int $noRm
 * @property string $namaPasien
 * @property int $kilometer
 * @property float $jasaSarana
 * @property float $jasaPelayanan
 * @property float $tarif
 * @property string $status 1:baru;2:lunas
 * @property string $publish
 * @property string|null $createDate
 * @property string|null $createBy
 * @property string|null $updateDate
 * @property string|null $updateBy
 *
 * @property JenisAmbulan $idJenisAmbulan0
 */
class TagihanAmbulan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tagihan_ambulan';
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
            [['idJenisAmbulan', 'idTagihan', 'tanggal', 'noRm', 'namaPasien', 'kilometer', 'jasaSarana', 'jasaPelayanan', 'tarif'], 'required'],
            [['idJenisAmbulan', 'idTagihan', 'noRm', 'kilometer'], 'integer'],
            [['tanggal', 'createDate', 'updateDate'], 'safe'],
            [['jasaSarana', 'jasaPelayanan', 'tarif'], 'number'],
            [['namaPasien'], 'string', 'max' => 75],
            [['status', 'publish'], 'string', 'max' => 1],
            [['createBy', 'updateBy'], 'string', 'max' => 30],
            [['idJenisAmbulan'], 'exist', 'skipOnError' => true, 'targetClass' => JenisAmbulan::class, 'targetAttribute' => ['idJenisAmbulan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idJenisAmbulan' => 'Id Jenis Ambulan',
            'idTagihan' => 'Id Tagihan',
            'tanggal' => 'Tanggal',
            'noRm' => 'No Rm',
            'namaPasien' => 'Nama Pasien',
            'kilometer' => 'Kilometer',
            'jasaSarana' => 'Jasa Sarana',
            'jasaPelayanan' => 'Jasa Pelayanan',
            'tarif' => 'Tarif',
            'status' => 'Status',
            'publish' => 'Publish',
            'createDate' => 'Create Date',
            'createBy' => 'Create By',
            'updateDate' => 'Update Date',
            'updateBy' => 'Update By',
        ];
    }

    /**
     * Gets query for [[IdJenisAmbulan0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdJenisAmbulan0()
    {
        return $this->hasOne(JenisAmbulan::class, ['id' => 'idJenisAmbulan']);
    }
}
