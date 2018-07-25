<?php

namespace app\modules\dashboard\controllers;

use app\modules\dashboard\models\Cart;
use app\modules\user\models\User;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;
use yii\web\ForbiddenHttpException;

class BackendController extends Controller {


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

    public function init() {
        parent::init(); // TODO: Change the autogenerated stub

        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Доступ заблокирован',403);
        }
        $userId = Yii::$app->user->getId();

        switch ($userId) {
            case User::ROLE_ADMIN : return true;
                break;
            case User::ROLE_USER : return $this->redirect('/client/client/index');
                break;
        }
    }

//    public function beforeAction() {
//        if (Yii::$app->user->can('admin') == User::ROLE_ADMIN) {
//            return $this->redirect(['/dashboard']);
//        } else {
//            throw new ForbiddenHttpException('dawdawd');
//        }
//    }
//
//    public function actionLogin() {
//        if (Yii::$app->user->isGuest) {
//            return $this->redirect(['/user/default/login']);
//        } else {
//            return $this->render('index');
//        }
//    }
//
    public function actionIndex()
    {
        $cart = new Cart();
        $count = $cart->getTotalFullOrder();

        return $this->render('index',[
            'count' => $count,
        ]);
    }

}
