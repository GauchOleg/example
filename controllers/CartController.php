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
        return $this->render('index');
    }

    public function actionAddToCart() {

        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('forbidden',403);
        }
        $cart = new Cart();
        $post = Yii::$app->request->post();
//        $dataProduct = Product::getProductById(Yii::$app->request->post('id'));
        $cart->addToCart($post);
        return true;
//        dd($dataProduct);
    }

}
