<?php

namespace app\controllers;
use app\modules\dashboard\models\Cart;
use Yii;

class FrontendController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $sessionId = Yii::$app->session->get('order_id');
        if (isset($sessionId) && !empty($sessionId)) {
            $cart = new Cart();
            $count = $cart->getCountProductInBasked($sessionId);
            $this->view->params['in_cart'] = $count;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
