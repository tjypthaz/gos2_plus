<?php

namespace app\modules\pembayaran\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tagihan_ambulan".
 *
 * @property int $id
 * @property int $idJenisAmbulan
 * @property string $idTagihan tagihan di simgos harus FINAL
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
            [['idJenisAmbulan', 'idTagihan', 'tanggal', 'noRm', 'namaPasien', 'kilometer'], 'required'],
            [['idJenisAmbulan', 'noRm', 'kilometer'], 'integer'],
            [['tanggal', 'createDate', 'updateDate'], 'safe'],
            [['jasaSarana', 'jasaPelayanan', 'tarif'], 'number'],
            [['idTagihan'], 'string', 'max' => 10],
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
            'idJenisAmbulan' => 'Jenis Pelayanan',
            'idTagihan' => 'Id Tagihan SIMGOS',
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

    public static function getPublish($id=null){
        $list = [
            1 => 'Ya',
            2 => 'Tidak',
        ];
        if($id == null){
            return $list;
        }
        return $list[$id];
    }

    public static function getStatus($id=null){
        $list = [
            1 => 'Blm Lunas',
            2 => 'Lunas',
        ];
        if($id == null){
            return $list;
        }
        return $list[$id];
    }

    public static function getJenisAmbulan($id=null){
        $list = ArrayHelper::map(JenisAmbulan::find()->where(['publish' => 1])->all(),'id','deskripsi');
        if($id == null){
            return $list;
        }
        return $list[$id];
    }

    public function beforeValidate()
    {
        // validasi data kembar berdasarkan nomer tagihan status publish = 1
        if($this->isNewRecord){
            $findDup = self::find()->where([
                'idTagihan' => $this->idTagihan,
                'publish' => '1'
            ])->one();
            if($findDup){
                $this->addError('idTagihan','Data Sudah Pernah Diinput');
            }
        }
        return true;
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert); // TODO: Change the autogenerated stub
        if($this->kilometer < 10){
            $this->tarif = 150000;
        }else{
            $this->tarif = $this->kilometer * $this->idJenisAmbulan0->hargaPerKM;
        }

        $this->jasaSarana = ($this->idJenisAmbulan0->jsProp/100) * $this->tarif;
        $this->jasaPelayanan = ($this->idJenisAmbulan0->jpProp/100) * $this->tarif;
        if($insert){
            $this->createBy = Yii::$app->user->identity->username;
            $this->createDate = date('Y-m-d H:i:s');
        }
        else{
            $this->updateBy = Yii::$app->user->identity->username;
            $this->updateDate = date('Y-m-d H:i:s');
        }
        return true;
    }
}
