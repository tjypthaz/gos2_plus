<?php

namespace app\modules\erm\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "diagnosa_keperawatan".
 *
 * @property int $ID
 * @property string $KODE
 * @property string $DESKRIPSI
 * @property int $STATUS
 */
class DiagnosaKeperawatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diagnosa_keperawatan';
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
            [['KODE'], 'required'],
            [['STATUS'], 'integer'],
            [['KODE'], 'string', 'max' => 20],
            [['DESKRIPSI'], 'string', 'max' => 350],
        ];
    }

    public static function getListDiagnosa(){

        $data = self::find()->select(['ID',"concat(KODE,' - ',DESKRIPSI) as NAMA"])
            ->where('STATUS = 1')->asArray()
            ->all();

        return ArrayHelper::map(
            $data
            ,'ID','NAMA');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KODE' => 'Kode',
            'DESKRIPSI' => 'Deskripsi',
            'STATUS' => 'Status',
        ];
    }
}
