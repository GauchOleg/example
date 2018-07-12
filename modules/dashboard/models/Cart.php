<?php

namespace app\modules\dashboard\models;

use Yii;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property int $id
 * @property string $order_id
 * @property string $product_info
 * @property string $customer_name
 * @property string $customer_phone
 * @property string $customer_email
 * @property int $status
 * @property string $session_id
 * @property int $finished
 * @property string $create_at
 * @property string $update_at
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'finished'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['order_id', 'product_info', 'customer_name', 'customer_phone', 'customer_email', 'session_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'product_info' => 'Product Info',
            'customer_name' => 'Customer Name',
            'customer_phone' => 'Customer Phone',
            'customer_email' => 'Customer Email',
            'status' => 'Status',
            'session_id' => 'Session ID',
            'finished' => 'Finished',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}