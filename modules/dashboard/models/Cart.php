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
            [['create_at', 'update_at', 'product_info'], 'safe'],
            [['order_id', 'customer_name', 'customer_phone', 'customer_email', 'session_id'], 'string', 'max' => 255],
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
        $order = self::findOne(['session_id' => $sessionId]);
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
        return $sessionId;
    }

    private function updateOrder($order,$dataProduct,$count) {
        $order->product_info = $this->equalOrderInfo($order->product_info,$dataProduct,$count);
        $order->update();
        return $order->session_id;
    }

    private function equalOrderInfo($orderInfo,$dataProduct,$count) {
        $newOrderInfo = $this->convertToJsonOrderData($dataProduct,$count);
        return $this->changeOldOrderInfo($orderInfo,$newOrderInfo);
    }

    private function changeOldOrderInfo($oldOrderInfo,$newOrderInfo) {
        $old = Json::decode($oldOrderInfo,true);
        $new = Json::decode($newOrderInfo,true);
        return $this->equalArrayData($old,$new);
    }

    // TODO дописать метод. 
    private function equalArrayData($old,$new) {
        $result = [];
        if (isset($old[0])) {
            foreach ($old as $value) {
                if ($value['product_id'] == $new['product_id']) {
                    continue;
                }
                array_push($result,$value);
            }
            array_push($result,$new);
        } else {
            if ($old['product_id'] != $new['product_id']) {
                array_push($result,$new);
                array_push($result,$old);
            } else {
                array_push($result,$new);
            }
        }
//        dd($result);
        return Json::encode($result);
    }

    private function convertToJsonOrderData($data,$count) {
        $orderData = [
            'product_id' => $data['id'],
            'product_price' => $data['price'],
            'product_count' => $count,
        ];
        return Json::encode($orderData,true);
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
            return $this->updateOrder($order,$dataProduct,$count);
        } else {
            return $this->addNewOrder($dataProduct,$sessionId,$count);
        }
    }

    public function getCountProductInBasked($sessionId) {
        $order = $this->getOrderBySessionId($sessionId);
        if ($order) {
            return count(Json::decode($order->product_info));
        }
    }

    public function getOrderDataBySessionId($sessionId) {
        $order = $this->getOrderBySessionId($sessionId);
        $i = 1;
        $allProduct = [];
        if (!is_null($order) && $order) {
            $orderInfo = Json::decode($order->product_info,true);
            foreach ($orderInfo as $item) {
                if ($item['product_id']) {
                    $product = Product::find()->where(['id' => $item['product_id']])->asArray()->one();
                    if (!is_null($product) && $product) {
                        $allProduct[] = [
                            'num'   => $i,
                            'id'    => $product['id'],
                            'code'  => $product['code'],
                            'alias' => $product['alias'],
                            'price' => $product['price'],
                            'count' => $item['product_count'],
                            'name'  => $product['name'],
                            'img'   => ProductImg::getImgByProductId($product['id'])

                        ];
                    }
                }
                $i++;
            }
        }
        return $allProduct;
    }

    public static function deleteItemCart($post) {
        if (empty($post)) {
            return false;
        }
        // TODO получить id товара из поста, получить ордер id удалить товар с таким ID и апдейт ордер все! завтра ...
    }

}