<?php

namespace app\modules\lis\models;

use Yii;

/**
 * This is the model class for table "ordered_item".
 *
 * @property string|null $order_number
 * @property string|null $order_item_id
 * @property string|null $order_item_name
 * @property string|null $order_item_datetime
 * @property int|null $order_status 0 = batal; 1 = aktif
 *
 * @property Registration $orderNumber
 */
class OrderedItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ordered_item';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_lis_bridging');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_item_datetime'], 'safe'],
            [['order_status'], 'integer'],
            [['order_number', 'order_item_id', 'order_item_name'], 'string', 'max' => 50],
            [['order_number'], 'exist', 'skipOnError' => true, 'targetClass' => Registration::class, 'targetAttribute' => ['order_number' => 'order_number']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_number' => 'Order Number',
            'order_item_id' => 'Order Item ID',
            'order_item_name' => 'Order Item Name',
            'order_item_datetime' => 'Order Item Datetime',
            'order_status' => 'Order Status',
        ];
    }

    /**
     * Gets query for [[OrderNumber]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderNumber()
    {
        return $this->hasOne(Registration::class, ['order_number' => 'order_number']);
    }
}
