<?php

namespace app\modules\dashboard\models;

use app\modules\user\models\User;
use app\modules\user\models\UserMeta;
use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;

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
 * @property string $date_ordered
 */
class Cart extends \yii\db\ActiveRecord
{


    const STATUS_ORDERED        = 1;
    const STATUS_PENDING        = 2;
    const STATUS_REFUSE         = 3;
    const STATUS_IN_PROCESSING  = 4;
    const STATUS_COMPLETED      = 5;

    const DELIVERY_SELF         = 1;
    const DELIVERY_HOME         = 2;
    const DELIVERY_POST         = 3;

    public $time_order;

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
            [['create_at', 'update_at', 'product_info', 'date_ordered'], 'safe'],
            [['order_id', 'customer_name', 'customer_phone', 'customer_email', 'session_id'], 'string', 'max' => 255],
            [['customer_email'],'email','message' => 'Проверте првильность ввода поля Email'],

            [['customer_l_name'], 'string'],
            [['customer_o_name', 'address', 'delivery', 'product_code'], 'string'],
            [['product_id','count','delivery', 'prices', 'total_price'], 'integer'],

            [['time_order'],'safe'],

            [['customer_name', 'customer_phone', 'customer_l_name'],'required', 'message' => '{attribute} не может быть пустым'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                => 'ID',
            'order_id'          => '№',
            'product_info'      => 'Информация о товарах',
            'customer_name'     => '* Имя',
            'customer_o_name'   => 'Отчество',
            'customer_l_name'   => '* Фамилия',
            'delivery'          => 'Способ доставки',
            'address'           => 'Адрес',
            'customer_phone'    => '* Телефон',
            'customer_email'    => 'Email',
            'status'            => 'Статус',
            'session_id'        => 'Session ID',
            'finished'          => 'Завершен',
            'create_at'         => 'Добавлено в карзину',
            'update_at'         => 'Заказан',
            'total_price'       => 'Общая сумма',
            'date_ordered'      => 'Дата заказа',
            'time_order'        => 'Время оформления заказа',
        ];
    }

    public static function getDeliveryList() {
        return [
            self::DELIVERY_SELF => 'Самовывоз',
            self::DELIVERY_HOME => 'Доставка по Харькову',
            self::DELIVERY_POST => 'Новая Почта',
        ];
    }

    public function getDelivery() {
        if (isset($this->delivery) && !is_null($this->delivery)) {
            return self::getDeliveryList()[$this->delivery];
        } else {
            return 'Уточнить';
        }
    }

    public static function updateOrderStatus($postData) {
        $order = self::getOrderById($postData['product_id']);
        if (!is_null($order)) {
            $order->status = $postData['status'];
            if ($order->update(false)){
                return [
                    'status' => $postData['status'],
                    'id' => $postData['product_id'],
                ];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function checkProperty($property) {
        if (isset($property) && !is_null($property)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkOrderedTime() {
        if ($this->checkProperty($this->create_at) && $this->checkProperty($this->date_ordered)) {
            $update_at = strtotime($this->create_at);
            $date_ordered = strtotime($this->date_ordered);
            $second = $date_ordered - $update_at;
            return $this->convertTime($second);
        }
    }

    private function convertTime($time) {
        $days = floor($time / 86400);
        $hours = floor($time / 3600);
        $minutes = floor($time / 60);

        if ($hours >= 24) {
            $hours = floor(($time - ($days * 86400)) / 3600);
        }
        if ($minutes > 59) {
            $minutes = floor((($time - (($days * 86400) + ($hours * 3600)))) / 60);
        }

        $seconds = $time - ($days * 86400 + $hours * 3600 + $minutes * 60);

        return $days . 'д-' . $hours . 'ч-' . $minutes . 'м-' . $seconds . 'c';
    }

    private function getOrderById($id) {
        return self::findOne(['id' => $id]);
    }

    public function getFullName() {
        return $this->customer_name . ' ' . $this->customer_l_name . ' ' . $this->customer_o_name;
    }

    public function getTotal() {
        if (isset($this->total_price)) {
            return $this->total_price . ' грн.';
        } else {
            return 0;
        }
    }

    public function beforeSave($insert)
    {
        $this->create_at = ($this->isNewRecord) ? date('Y-m-d H:i:s') : $this->create_at;
        $this->update_at = ($this->isNewRecord) ? '' : date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }

    public static function getOrderStatusList() {
        return [
            self::STATUS_ORDERED        => 'Новый',
            self::STATUS_IN_PROCESSING  => 'Обрабатывается',
            self::STATUS_PENDING        => 'В ожидании',
            self::STATUS_REFUSE         => 'Отказ',
            self::STATUS_COMPLETED      => 'Завершен',
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
//        $this->status = self::STATUS_START;
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
            $cookies = Yii::$app->request->cookies;
            if (isset($cookies['order_id'])) {
                $order_id = $cookies['order_id']->value;
                Yii::$app->session->set('order_id',$order_id);
            } else {
                $order_id = $this->getOrderId();
                Yii::$app->session->set('order_id',$order_id);
                $new_cookie = new Cookie([
                    'name' => 'order_id',
                    'value' => $order_id,
                    'expire' => time() + 86400 * 365,
                ]);
                Yii::$app->getResponse()->getCookies()->add($new_cookie);
            }
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
                        "product_price" => $prices[$item],
                        "product_count" => $count[$item],
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
            $order->customer_name   = $post['Cart']['customer_name'];
            $order->customer_l_name = $post['Cart']['customer_l_name'];
            $order->customer_email  = $post['Cart']['customer_email'];
            $order->customer_phone  = $post['Cart']['customer_phone'];
            $order->delivery        = $post['Cart']['delivery'];
            $order->address         = $post['Cart']['address'];
            $order->total_price     = $post['total_price'];
//            $order->product_code = self::setJsonData($post);
            $order->status          = self::STATUS_ORDERED;
            $order->order_id        = '#'.time();
            $order->product_info    = self::setJsonData($post,'info');
            $order->date_ordered    = date('Y-m-d H:i:s');
            if ($order->update(false)) {
                self::addNewClient($order);
                Yii::$app->session->remove('order_id');
                $cookies = Yii::$app->response->cookies;
                $cookies->remove('order_id');
                return $order->order_id;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function addNewClient($order) {
        $phone = self::prepareClientPhone($order->customer_phone);
        if (self::findUserByPhone($phone)) {
            return;
        }
        $user = new User();
        $user->username = $phone;
        $user->email = ($order->customer_email) ? $order->customer_email : '';
        $user->status = User::STATUS_APPROVED;
        $user->role = User::ROLE_USER;
        $user->password = $phone;
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->referral_code = Yii::$app->security->generateRandomString(12);
        $user->access_token = Yii::$app->security->generateRandomString(40);
        if ($user->save(false)) {
            $userMeta = new UserMeta();
            $userMeta->user_id = $user->id;
            $userMeta->meta_key = 'phone';
            $userMeta->meta_value = $order->customer_phone;
            $userMeta->save(false);
        }
    }
    
    private function findUserByPhone($phone) {
        $user = new User();
        return $user->findUserByUsername($phone);
    }

    private function prepareClientPhone($phone) {
        if (isset($phone)) {
            return preg_replace('/-/','',preg_replace('/\) /','',preg_replace('/(\+38){1}(\(){1}/','',$phone)));
        }
    }

    private function getIdsProductFromProductInfoProperty($order_info) {
        if (is_array($order_info) && !empty($order_info)) {
            $ids = [];
            foreach ($order_info as $product) {
                if ($product['product_id']) {
                    array_push($ids,$product['product_id']);
                }
            }
            return $ids;
        } else {
            return false;
        }
    }

    private function getProductsByIds($ids) {
        return Product::find()->where(['in','id',$ids])->asArray()->indexBy('id')->all();
    }

    public function getTotalFullOrder() {
        return count(self::find()->where(['not', ['order_id' => null]])->asArray()->all());
    }

    public function printOrderInfo() {
        if (isset($this->product_info) && !empty($this->product_info)) {
            $order_info = Json::decode($this->product_info);
            $product_ids = $this->getIdsProductFromProductInfoProperty($order_info);
            $products = $this->getProductsByIds($product_ids);
            $render = '';
            $total_sum = [];
//            dd($order_info);
            if (!is_null($products)) {
                foreach ($order_info as $item) {
                    if (isset($products[$item['product_id']])) {
                        $render .= Html::a($products[$item['product_id']]['name'],['/product/view','alias' => $products[$item['product_id']]['alias']],['target' => '_blank']) . '<br> ';
                        $render .= 'Кол-во: ' . $item['product_count'] . '<br>';
                        $render .= 'Цена на момент заказа: ' . $item['product_price'] . ' грн. <br>';
                        $render .= '---------------<br>';
                        array_push($total_sum,$item['product_count'] * $item['product_price']);
                    }
                }
                $render .= 'Всего на сумму: <b>' . number_format(array_sum($total_sum),2) . '</b> грн.';
                return $render;
            } else {
                return 'Пусто';
            }
        } else {
            return 'Пусто';
        }
    }

    public function checkStatus($status = false,$id = false) {

        if ($status && $id) {
            $this->status = $status;
            $this->id = $id;
        }
        $class = 'order-status';
        $button_color = '';
        $status = '';
        $url = '"update-status"';

        $statusList = self::getOrderStatusList();
        $statusName = $statusList[$this->status];

        switch ($this->status) {
            case self::STATUS_ORDERED : $status = '<span class="'. $class .'">'. $statusName .'</span>'; $button_color = 'status-ordered';
                break;
            case self::STATUS_COMPLETED : $status = '<span class="'. $class .'">'. $statusName .'</span>'; $button_color = 'status-completed';
                break;
            case self::STATUS_IN_PROCESSING : $status = '<span class="'. $class .'">'. $statusName .'</span>'; $button_color = 'status-in-completed';
                break;
            case self::STATUS_REFUSE : $status = '<span class="'. $class .'">'. $statusName .'</span>'; $button_color = 'status-refuse';
                break;
            case self::STATUS_PENDING : $status = '<span class="'. $class .'">'. $statusName .'</span>'; $button_color = 'status-pending';
                break;
            default : $status = 'не определен';
        }

        $checked_ordered = ($this->status == self::STATUS_ORDERED) ? ' checked' : '';
        $checked_in_processing = ($this->status == self::STATUS_IN_PROCESSING) ? ' checked' : '';
        $checked_pending = ($this->status == self::STATUS_PENDING) ? ' checked' : '';
        $checked_refuse = ($this->status == self::STATUS_REFUSE) ? ' checked' : '';
        $checked_completed = ($this->status == self::STATUS_COMPLETED) ? ' checked' : '';

        $checkbox = "<ul class='checkbox-status' data-product-id='". $this->id ."'>
                        <li><input class='check' type='checkbox' data-name='". $statusList[self::STATUS_ORDERED] ."' name='status' value='". self::STATUS_ORDERED ."'".  $checked_ordered .">" . $statusList[self::STATUS_ORDERED] . "</li>
                        <li><input class='check' type='checkbox' data-name='". $statusList[self::STATUS_IN_PROCESSING] ."' name='status' value='". self::STATUS_IN_PROCESSING."'".  $checked_in_processing .">" . $statusList[self::STATUS_IN_PROCESSING] . "</li>
                        <li><input class='check' type='checkbox' data-name='". $statusList[self::STATUS_PENDING] ."' name='status' value='". self::STATUS_PENDING ."'".  $checked_pending .">" . $statusList[self::STATUS_PENDING] . "</li>
                        <li><input class='check' type='checkbox' data-name='". $statusList[self::STATUS_REFUSE] ."' name='status' value='". self::STATUS_REFUSE ."'".  $checked_refuse .">" . $statusList[self::STATUS_REFUSE] . "</li>
                        <li><input class='check' type='checkbox' data-name='". $statusList[self::STATUS_COMPLETED] ."' name='status' value='". self::STATUS_COMPLETED ."'".  $checked_completed .">" . $statusList[self::STATUS_COMPLETED] . "</li>
                    </ul>";

        $proper = "<span data-button-id='".$this->id."'><button type=\"button\"
                           data-html=\"true\" 
                           class=\"btn btn-default ". $button_color ."\" 
                           data-container=\"body\" 
                           data-toggle=\"popover\" 
                           data-placement=\"left\" 
                           data-content=\" ". $checkbox ."\">
                           ". $status ."
                           </button>
                   </span>
                <script>
                    $(document).ready(function () {
                
                       $('.btn-default').on('click',function(){
                           $(this).popover('show');
                           var button = $(this);
                           $('.check').change(function(){
                               $('input[name=\"' + $(this).attr('name') +'\"]').removeAttr('checked');
                               $(this).prop('checked', true);
                               var old_data_content =  button.data('content');
                               var status = $(this).val();
                               var label = $(this).data('name');
                               var product_id = $(this).parent().parent('ul').data('product-id');
                               var class_status = checkStatus(status);
                               $.ajax({
                                   url: ". $url .",
                                   type: \"POST\",
                                   data: {_csrf: yii.getCsrfToken(),status: status,product_id: product_id},
                                   success: function (res) {
                                       if (res) {
                                           button.popover('hide');
                                           $(\"[data-button-id=\"+ product_id + \"]\").parent('td').html(res);
                                       }
                                   },
                                   error: function () {
                                       console.log('some error on cart controller .. ');
                                   }
                               });
                           });
                       });
                
                        function checkStatus(status) {
                            var new_class = '';
                            switch (parseInt(status)){
                                case 1 : new_class = 'status-ordered';
                                    break;
                                case 5 : new_class = 'status-completed';
                                    break;
                                case 4 : new_class = 'status-in-completed';
                                    break;
                                case 3 : new_class = 'status-refuse';
                                    break;
                                case 2 : new_class = 'status-pending';
                                    break;
                            }
                            return new_class;
                        }
                
                
                    });
                </script>";

        return $proper;
    }

}