<?php

namespace app\modules\client\controllers;

use Yii;
use app\modules\dashboard\searchModels\Cart;

class PersonalController extends IndexController {


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrders() {

        if (isset(Yii::$app->user->identity->metaData->phone)) {
            $phone = Yii::$app->user->identity->metaData->phone;
            $cart = new Cart();
            $params = [
                'Cart' =>
                    ['customer_phone' => $phone]
            ];
            $dataProvider = $cart->search($params);
            return $this->render('clients-orders',[
                'dataProvider' => $dataProvider,
            ]);
        }

        return $this->render('users',[
        ]);
    }

}
