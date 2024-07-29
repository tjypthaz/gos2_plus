<?php

namespace app\modules\erm\models;

use Yii;

/**
 * This is the model class for table "mapping_intervensi_indikator".
 *
 * @property int $ID
 * @property int $JENIS
 * @property int $INDIKATOR
 * @property int $INTERVENSI
 * @property int $STATUS
 */
class MappingIntervensiIndikator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mapping_intervensi_indikator';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_erm');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['JENIS', 'INTERVENSI', 'STATUS'], 'integer'],
            [['INDIKATOR'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'JENIS' => 'Jenis',
            'INDIKATOR' => 'Indikator',
            'INTERVENSI' => 'Intervensi',
            'STATUS' => 'Status',
        ];
    }
}
