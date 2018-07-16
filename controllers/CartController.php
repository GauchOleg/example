<?php

namespace app\controllers;

use app\modules\dashboard\models\Cart;
use app\modules\dashboard\models\Product;
use Yii;
use yii\web\BadRequestHttpException;

class CartController extends FrontendController
{
    public function actionIndex()
    {
        $sessionId = Yii::$app->session->get('order_id');
        $cart = new Cart();
        $orderData = $cart->getOrderDataBySessionId($sessionId);

        return $this->render('index',[
            'orderData' => $orderData,
            'model'     => $cart,
        ]);
    }

    public function actionAddToCart() {

        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('forbidden',403);
        }
        $cart = new Cart();
        $post = Yii::$app->request->post();
        $sessionId = $cart->addToCart($post);
        $countProducts = $cart->getCountProductInBasked($sessionId);
        return $countProducts;
    }

    public function actionDeleteProduct() {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }
        $post = Yii::$app->request->post();
        $cart = new Cart();
        $sessionId = $cart->deleteItemCart($post);
        $orderData = $cart->getOrderDataBySessionId($sessionId);
        return $this->renderPartial('cart',[
            'orderData' => $orderData,
            'model'     => $cart,
        ]);
    }
    
    public function actionSave() {

        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException('Ой, как вы тут оказались? Вернитесь и оформите заказ', 400);
        }
        
        $post = Yii::$app->request->post();
        $result = Cart::saveNewOrder($post);


//        dd(Yii::$app->request->post());

//        $sessionId = Yii::$app->session->get('order_id');
//        $cart = new Cart();
//        $orderData = $cart->getOrderDataBySessionId($sessionId);
//        return $this->renderPartial('order',[
//            'orderData' => $orderData,
//            'model'     => $cart,
//        ]);
    }

}
