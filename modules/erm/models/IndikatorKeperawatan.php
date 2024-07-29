<?php

namespace app\modules\erm\models;

use Yii;

/**
 * This is the model class for table "indikator_keperawatan".
 *
 * @property int $JENIS
 * @property int $ID
 * @property string $DESKRIPSI
 * @property int $STATUS
 */
class IndikatorKeperawatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'indikator_keperawatan';
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
            [['JENIS', 'DESKRIPSI'], 'required'],
            [['JENIS', 'STATUS'], 'integer'],
            [['DESKRIPSI'], 'string', 'max' => 350],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'JENIS' => 'Jenis',
            'ID' => 'ID',
            'DESKRIPSI' => 'Deskripsi',
            'STATUS' => 'Status',
        ];
    }
}
