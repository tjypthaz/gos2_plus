<?php

namespace app\modules\jaspel\models;

use Yii;

/**
 * This is the model class for table "jaspel_final".
 *
 * @property int $id
 * @property int $idJaspel
 * @property string $idRuangan
 * @property string $ruangan
 * @property string $tindakan
 * @property int|null $idDokterO
 * @property int|null $idDokterL
 * @property int|null $idPara
 * @property float|null $jpDokterO
 * @property float|null $jpDokterL
 * @property float|null $jpPara
 * @property float|null $jpStruktural
 * @property float|null $jpBlud
 * @property float|null $jpPegawai
 */
class JaspelFinal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jaspel_final';
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
            [['idJaspel', 'idRuangan', 'ruangan', 'tindakan'], 'required'],
            [['idJaspel', 'idDokterO', 'idDokterL', 'idPara'], 'integer'],
            [['jpDokterO', 'jpDokterL', 'jpPara', 'jpStruktural', 'jpBlud', 'jpPegawai'], 'number'],
            [['idRuangan'], 'string', 'max' => 9],
            [['ruangan'], 'string', 'max' => 35],
            [['tindakan'], 'string', 'max' => 50],
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
            'ruangan' => 'Ruangan',
            'tindakan' => 'Tindakan',
            'idDokterO' => 'Id Dokter O',
            'idDokterL' => 'Id Dokter L',
            'idPara' => 'Id Para',
            'jpDokterO' => 'Jp Dokter O',
            'jpDokterL' => 'Jp Dokter L',
            'jpPara' => 'Jp Para',
            'jpStruktural' => 'Jp Struktural',
            'jpBlud' => 'Jp Blud',
            'jpPegawai' => 'Jp Pegawai',
        ];
    }
}
