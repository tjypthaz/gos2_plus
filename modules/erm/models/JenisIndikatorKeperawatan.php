<?php

namespace app\modules\erm\models;

use Yii;

/**
 * This is the model class for table "jenis_indikator_keperawatan".
 *
 * @property int $ID
 * @property string $DESKRIPSI
 * @property int $STATUS
 */
class JenisIndikatorKeperawatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_indikator_keperawatan';
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
            [['DESKRIPSI'], 'required'],
            [['STATUS'], 'integer'],
            [['DESKRIPSI'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'DESKRIPSI' => 'Deskripsi',
            'STATUS' => 'Status',
        ];
    }
}
