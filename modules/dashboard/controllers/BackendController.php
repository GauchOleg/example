<?php

namespace app\modules\dashboard\controllers;

use app\modules\dashboard\models\Cart;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class BackendController extends Controller
{

    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                        'denyCallback' => function ($rule, $action) {
                            throw new \Exception('Permissions denied');
                        }
                    ],
                ],
            ],
        ];
    }

    public function beforeAction() {
        if ($user = Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }
        dd($user);
    }

    public function actionIndex()
    {
        $cart = new Cart();
        $count = $cart->getTotalFullOrder();
        return $this->render('index',[
            'count' => $count,
        ]);
    }

}
