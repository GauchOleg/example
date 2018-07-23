<?php

namespace app\controllers;
use app\modules\dashboard\models\Cart;
use app\modules\dashboard\models\Product;
use app\modules\dashboard\searchModels\ProductSearch;
use Yii;

class FrontendController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $sessionId = Yii::$app->session->get('order_id');
        $cart = new Cart();
        if (isset($sessionId) && !empty($sessionId)) {
            $count = $cart->getCountProductInBasked($sessionId);
            $this->view->params['in_cart'] = $count;
        } else {
            $cookies = Yii::$app->request->cookies;
            if (isset($cookies['order_id'])) {
                $count = $cart->getCountProductInBasked($cookies['order_id']->value);
                $this->view->params['in_cart'] = $count;
                Yii::$app->session->set('order_id',$cookies['order_id']->value);
            } else {
                $this->view->params['in_cart'] = null;
            }
        }
        $this->view->params['allProduct'] = Product::getAllProductAsArray();
        $this->view->params['search'] = new ProductSearch();
        
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
