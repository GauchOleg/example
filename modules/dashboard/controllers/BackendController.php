<?php

namespace app\modules\dashboard\controllers;

use app\modules\dashboard\models\Cart;
use yii\filters\AccessControl;
use yii\web\Controller;

class BackendController extends Controller
{

//    public function behaviors() {
//
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['admin', 'admin-did', 'admin-mcb', 'admin-all'],
//                        'denyCallback' => function ($rule, $action) {
//                            throw new \Exception('Permissions denied');
//                        }
//                    ],
//                ],
//            ],
//        ];
//    }

    public function actionIndex()
    {
        $cart = new Cart();
        $count = $cart->getTotalFullOrder();
        return $this->render('index',[
            'count' => $count,
        ]);
    }

}
