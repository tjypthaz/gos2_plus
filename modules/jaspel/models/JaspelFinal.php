<?php

namespace app\modules\jaspel\models;

use Yii;

/**
 * This is the model class for table "jaspel_final".
 *
 * @property int $id
 * @property int $idJaspel
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
            [['idJaspel'], 'required'],
            [['idJaspel'], 'integer'],
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
        ];
    }
}
