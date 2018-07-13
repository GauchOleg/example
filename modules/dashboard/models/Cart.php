<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\helpers\Json;

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

    const STATUS_START          = 1;
    const STATUS_UN_COMPLETED   = 2;
    const STATUS_COMPLETED      = 3;

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

    public function beforeSave($insert)
    {
        $this->create_at = ($this->isNewRecord) ? date('Y-m-d H:i:s') : $this->create_at;
        $this->update_at = ($this->isNewRecord) ? '' : date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }

    public static function getOrderStatusList() {
        return [
            self::STATUS_START => 'Начят',
            self::STATUS_UN_COMPLETED => 'Не завершен',
            self::STATUS_COMPLETED => 'Завершен',
        ];
    }

    private function getOrderId() {
        return Yii::$app->security->generateRandomString(16);
    }

    private function getOrderBySessionId($sessionId) {
        $order = self::find()->where(['session_id' => $sessionId])->one();
        if (!is_null($order) && $order) {
            return $order;
        } else {
            return false;
        }
    }

    private function addNewOrder($dataProduct,$sessionId,$count) {
        $this->session_id = $sessionId;
        $this->product_info = $this->convertToJsonOrderData($dataProduct,$count);
        $this->status = self::STATUS_START;
        $this->finished = false;
        $this->save(false);
        return true;
    }

    private function updateOrder($order,$dataProduct,$count) {
        $this->product_info = $this->equalOrderInfo($order->product_info,$dataProduct,$count);
        $this->update(false);
    }

    private function equalOrderInfo($orderInfo,$dataProduct,$count) {
        $newOrderInfo = $this->convertToJsonOrderData($dataProduct,$count);
        return $this->changeOldOrderInfo($orderInfo,$newOrderInfo);
    }

    private function changeOldOrderInfo($oldOrderInfo,$newOrderInfo) {
        $old = Json::decode($oldOrderInfo);
        $new = Json::decode($newOrderInfo);
        return $this->equalArrayData($old,$new);
    }

    // TODO дописать метод. 
    private function equalArrayData($old,$new) {
//        dd($old);
        $result = [];
        foreach ($old as $value) {
            if ($value['product_id'] != $new['product_id']) {
                array_push($result,$value);
            } else {
                if ($value['product_count'] != $new['product_count'] || $value['product_price'] != $new['product_price']) {
                    $updated = [
                        'product_id' => $new['product_id'],
                        'product_price' => $new['product_price'],
                        'product_count' => $new['product_count'],
                    ];
                    array_push($result,$updated);
                }
            }
        }
        return Json::encode($result);
    }

    private function convertToJsonOrderData($data,$count) {
        $orderData = [
            'product_id' => $data['id'],
            'product_price' => $data['price'],
            'product_count' => $count,
        ];
        return Json::encode($orderData);
    }

    public function addToCart($post) {
        $productId  = $post['id'];
        $count      = $post['count'];
        $dataProduct = Product::getProductById($productId);

        if (!$dataProduct || is_null($dataProduct)) {
            return false;
        }
        $order_id = Yii::$app->session->get('order_id');
        if (is_null($order_id)){
            $order_id = $this->getOrderId();
            Yii::$app->session->set('order_id',$order_id);
        }
        $result = $this->saveOrder($dataProduct,$order_id,$count);
        return $result;
    }

    private function saveOrder($dataProduct,$sessionId,$count) {
        $order = $this->getOrderBySessionId($sessionId);
        if ($order) {
            $this->updateOrder($order,$dataProduct,$count);
        } else {
            $this->addNewOrder($dataProduct,$sessionId,$count);
        }
    }

}