<?php

namespace app\modules\berkas\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "terima_berkas".
 *
 * @property int $ID
 * @property string|null $NOPEN
 * @property string|null $TGL_TERIMA
 * @property int|null $TERIMA
 * @property string|null $KETERANGAN
 * @property int|null $KASUS_KHUSUS
 * @property int|null $INFORMED_CONSENT
 * @property int|null $RESUME_MEDIS
 * @property string|null $TGL_KEMBALI
 * @property string|null $RUANGAN_KEMBALI
 * @property int|null $OLEH
 * @property int|null $STATUS
 */
class TerimaBerkas extends \yii\db\ActiveRecord
{
    public $noRm;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'terima_berkas';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_berkas');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TGL_TERIMA', 'TGL_KEMBALI'], 'safe'],
            [['TERIMA', 'KASUS_KHUSUS', 'INFORMED_CONSENT', 'RESUME_MEDIS', 'OLEH', 'STATUS'], 'integer'],
            [['NOPEN', 'RUANGAN_KEMBALI'], 'string', 'max' => 10],
            [['KETERANGAN'], 'string', 'max' => 200],
            [['NOPEN'], 'unique'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NOPEN' => 'Id Reg',
            'TGL_TERIMA' => 'Tgl Terima',
            'TERIMA' => 'Terima',
            'KETERANGAN' => 'Keterangan',
            'KASUS_KHUSUS' => 'Kasus Khusus',
            'INFORMED_CONSENT' => 'Informed Consent',
            'RESUME_MEDIS' => 'Resume Medis',
            'TGL_KEMBALI' => 'Tgl Kembali',
            'RUANGAN_KEMBALI' => 'Ruangan Kembali',
            'OLEH' => 'Oleh',
            'STATUS' => 'Status',
            'noRm' => 'No RM'
        ];
    }

    public static function getStatusTerima($id=null){
        $list = ArrayHelper::map(Yii::$app->db_berkas->createCommand("
        SELECT a.`ID`,a.`DESKRIPSI`
        FROM master.`referensi` a
        WHERE a.`JENIS` = 903301 AND a.`STATUS` = 1
        ")->queryAll(),'ID','DESKRIPSI');

        if($id == null){
            return $list;
        }
        return $list[$id];
    }

    public static function getStatusBerkasRm($id=null){
        $list = ArrayHelper::map(Yii::$app->db_berkas->createCommand("
        SELECT a.`ID`,a.`DESKRIPSI`
        FROM master.`referensi` a
        WHERE a.`JENIS` = 903305 AND a.`STATUS` = 1
        ")->queryAll(),'ID','DESKRIPSI');

        if($id == null){
            return $list;
        }
        return $list[$id];
    }

    public static function getStatusKasusKhusus($id=null){
        $list = ArrayHelper::map(Yii::$app->db_berkas->createCommand("
        SELECT a.`ID`,a.`DESKRIPSI`
        FROM master.`referensi` a
        WHERE a.`JENIS` = 903302 AND a.`STATUS` = 1
        ")->queryAll(),'ID','DESKRIPSI');

        if($id == null){
            return $list;
        }
        return $list[$id];
    }

    public static function getStatusInformedConsent($id=null){
        $list = ArrayHelper::map(Yii::$app->db_berkas->createCommand("
        SELECT a.`ID`,a.`DESKRIPSI`
        FROM master.`referensi` a
        WHERE a.`JENIS` = 903303 AND a.`STATUS` = 1
        ")->queryAll(),'ID','DESKRIPSI');

        if($id == null){
            return $list;
        }
        return $list[$id];
    }

    public static function getDatapasien($idReg){
        $data = Yii::$app->db_berkas->createCommand("
        SELECT CONCAT(b.`NORM`,'<br>',b.`NAMA`)
        FROM `pendaftaran`.`pendaftaran` a
        LEFT JOIN master.`pasien` b ON b.`NORM` = a.`NORM`
        WHERE a.`NOMOR` = :idReg
        ")->bindValue(':idReg',$idReg)
            ->queryScalar();

        return $data;
    }
}
