<?php

namespace app\modules\dashboard\controllers;

use app\modules\dashboard\models\Cart;
use app\modules\user\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;

class BackendController extends Controller {


    public function behaviors() {

        $behaviors = parent::behaviors();
        $array =  [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'logout'],
                        'roles' => ['admin'],
                        'denyCallback' => function ($rule, $action) {
                            throw new \Exception('Permissions denied');
                        }
                    ],
                ],
            ],
        ];
        return ArrayHelper::merge($behaviors,$array);
    }

//    public function beforeAction() {
//        if (Yii::$app->user->isGuest) {
//            return $this->redirect(['/user/default/login']);
//        } else {
//            return true;
//        }
//    }

    public function actionLogin() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        } else {
            return $this->render('index');
        }
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
