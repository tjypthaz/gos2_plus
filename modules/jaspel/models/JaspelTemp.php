<?php

namespace app\modules\jaspel\models;

use Yii;

/**
 * This is the model class for table "jaspel_temp".
 *
 * @property int $id
 * @property int $idJaspel
 * @property string $idRuangan
 * @property string $idTindakanMedis
 * @property string $idTindakan
 * @property int|null $idDokterO
 * @property float|null $jpDokterO
 * @property int|null $idDokterL
 * @property float|null $jpDokterL
 * @property int|null $idPara
 * @property float|null $jpPara
 * @property float|null $jpPegawai
 *
 * @property Jaspel $idJaspel0
 */
class JaspelTemp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jaspel_temp';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_jaspel');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idJaspel', 'idRuangan', 'idTindakanMedis', 'idTindakan'], 'required'],
            [['idJaspel', 'idDokterO', 'idDokterL', 'idPara'], 'integer'],
            [['jpDokterO', 'jpDokterL', 'jpPara', 'jpPegawai'], 'number'],
            [['idRuangan'], 'string', 'max' => 9],
            [['idTindakanMedis'], 'string', 'max' => 11],
            [['idTindakan'], 'string', 'max' => 10],
            [['idJaspel'], 'exist', 'skipOnError' => true, 'targetClass' => Jaspel::class, 'targetAttribute' => ['idJaspel' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idJaspel' => 'Id Jaspel',
            'idRuangan' => 'Id Ruangan',
            'idTindakanMedis' => 'Id Tindakan Medis',
            'idTindakan' => 'Id Tindakan',
            'idDokterO' => 'Id Dokter O',
            'jpDokterO' => 'Jp Dokter O',
            'idDokterL' => 'Id Dokter L',
            'jpDokterL' => 'Jp Dokter L',
            'idPara' => 'Id Para',
            'jpPara' => 'Jp Para',
            'jpPegawai' => 'Jp Pegawai',
        ];
    }

    /**
     * Gets query for [[IdJaspel0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdJaspel0()
    {
        return $this->hasOne(Jaspel::class, ['id' => 'idJaspel']);
    }
}
