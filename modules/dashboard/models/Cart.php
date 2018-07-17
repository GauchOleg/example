<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property int $id
 * @property string $order_id
 * @property string $product_info
 * @property string $customer_name
 * @property string $customer_l_name
 * @property string $customer_o_name
 * @property string $product_code
 * @property string $address
 * @property string $customer_phone
 * @property string $customer_email
 * @property int $status
 * @property int $product_id
 * @property int $count
 * @property int $delivery
 * @property int $prices
 * @property int $total_price
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
    const STATUS_ORDERED        = 4;

    const DELIVERY_SELF         = 1;
    const DELIVERY_HOME         = 2;
    const DELIVERY_POST         = 3;

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

            [['customer_l_name'], 'string'],
            [['customer_o_name', 'address', 'delivery', 'product_code'], 'string'],
            [['product_id','count','delivery', 'prices', 'total_price'], 'integer'],

            [['customer_name', 'customer_phone', 'customer_l_name'],'required', 'message' => '{attribute} не может быть пустым'],
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
            'customer_name' => '* Имя',
            'customer_o_name' => 'Отчество',
            'customer_l_name' => '* Фамилия',
            'delivery' => 'Способ доставки',
            'address' => 'Адрес',
            'customer_phone' => '* Телефон',
            'customer_email' => 'Customer Email',
            'status' => 'Status',
            'session_id' => 'Session ID',
            'finished' => 'Finished',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    public static function getDeliveryList() {
        return [
            self::DELIVERY_SELF => 'Самовывоз',
            self::DELIVERY_HOME => 'Доставка по Харькову',
            self::DELIVERY_POST => 'Новая Почта',
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
        $order->customer_name = 'null';
        $order->customer_phone = 'null';
        $order->customer_l_name = 'null';
        $order->product_info = $this->equalOrderInfo($order->product_info,$dataProduct,$count);
        $order->update();
        return $order->session_id;
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
            return $this->updateOrder($order,$dataProduct,$count);
        } else {
            return $this->addNewOrder($dataProduct,$sessionId,$count);
        }
    }

    public function getCountProductInBasked($sessionId) {
        $order = $this->getOrderBySessionId($sessionId);
        if ($order) {
            $productInfo = Json::decode($order->product_info);
            if (isset($productInfo[0])) {
                return count($productInfo);
            } else {
                return 1;
            }
        } else {
            return null;
        }
    }

    public function getOrderDataBySessionId($sessionId) {
        $order = $this->getOrderBySessionId($sessionId);
        $i = 1;
        $allProduct = [];
        if (!is_null($order) && $order) {
            $orderInfo = Json::decode($order->product_info);
            if (isset($orderInfo[0])) {
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
                                'img'   => ProductImg::getImg($product['id'],false,false,'cart')
                            ];
                        }
                    }
                    $i++;
                }
            } else {
                $product = Product::find()->where(['id' => $orderInfo['product_id']])->asArray()->one();
                if (!is_null($product) && $product) {
                    $allProduct[] = [
                        'num'   => $i,
                        'id'    => $product['id'],
                        'code'  => $product['code'],
                        'alias' => $product['alias'],
                        'price' => $product['price'],
                        'count' => $orderInfo['product_count'],
                        'name'  => $product['name'],
                        'img'   => ProductImg::getImg($product['id'],false,false,'cart')

                    ];
                }
            }
        }
        return $allProduct;
    }

    public function deleteItemCart($post) {
        if (empty($post)) {
            return false;
        }
        $orderId = Yii::$app->session->get('order_id');
        $newOrderData = [];
        if (isset($orderId) && !empty($orderId)) {
            $order = self::getOrderBySessionId($orderId);
            $orderInfo = Json::decode($order->product_info);
            if (count($orderInfo) != 1 && isset($orderInfo[0])) {
                foreach ($orderInfo as $item) {
                    if ($item['product_id'] == $post['productId']) {
                        continue;
                    } else {
                        array_push($newOrderData,$item);
                    }
                }
                $order->product_info = Json::encode($newOrderData);
                $order->update();
            } else {
                $order->delete();
            }
            return $orderId;
        } else {
            return false;
        }
    }

    public static function getTotalPrice($orderData) {
        $prices = [];
        if (is_array($orderData[0])) {
            foreach ($orderData as $item) {
                if ($item['count'] != 0 && !empty($item['price'])) {
                    array_push($prices, bcmul($item['count'],$item['price']));
                }
            }
        }
//        dd($prices);
        return array_sum($prices) . ' грн.';
    }

    private function setJsonData($post, $field=false) {
        $product_id     = $post['product_id'];
        $product_code   = $post['product_code'];
        $count          = $post['count'];
        $prices         = $post['prices'];
        $result = [];

        if ($field) {
            foreach ($product_id as $item) {
                if (isset($product_code[$item]) && isset($count[$item]) && isset($prices[$item])) {
                    $result[] = [
                        "product_id"    => $item,
                        "product_price" => $count[$item],
                        "product_count" => $prices[$item],
                    ];
                }
            }
        } else {
            foreach ($product_id as $value) {
                if (isset($product_code[$value])) {
                    $result[$value] = $product_code[$value];
                }
            }
        }
        return Json::encode($result);
    }

    public static function saveNewOrder($post) {
        if (!empty($post)){
//            dd($post);
            $sessionId = Yii::$app->session->get('order_id');
            $order = self::getOrderBySessionId($sessionId);
            $order->customer_name = $post['Cart']['customer_name'];
            $order->customer_l_name = $post['Cart']['customer_l_name'];
            $order->customer_o_name = $post['Cart']['customer_o_name'];
            $order->customer_phone = $post['Cart']['customer_phone'];
            $order->delivery = $post['Cart']['delivery'];
            $order->address = $post['Cart']['address'];
            $order->total_price = $post['total_price'];
//            $order->product_code = self::setJsonData($post);
            $order->status = self::STATUS_ORDERED;
            $order->order_id = '#'.time();
            $order->product_info = self::setJsonData($post,'info');
            if ($order->update(false)) {
                Yii::$app->session->remove('order_id');
                return $order->order_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}