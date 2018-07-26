<?php

namespace app\modules\client\controllers;


use app\modules\user\models\UserMeta;
use Yii;
use app\modules\dashboard\models\Cart;
use app\modules\user\models\User;
use yii\web\BadRequestHttpException;

class SettingsController extends IndexController
{
//    public function actionIndex()
//    {
//        return $this->render('my');
//    }

    public function actionMy() {
//        $user = new User();
        $identity = Yii::$app->user->identity;
        $id = $identity->getId();
        $user = User::find()->where(['id' => $id])->one();
        $countOrders = Cart::getTotalOrdersByPhone($identity->metaData->phone);
        $meta = UserMeta::findOne(['user_id' => $id]);

        return $this->render('my',[
            'user' => $user,
            'countOrders' => $countOrders,
            'meta' => $meta,
        ]);
    }

    public function actionUpdateProfile() {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        dd(Yii::$app->request->post());
        $user = new User();
    }

    public function actionUpdatePassword() {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        $id = Yii::$app->user->identity->getId();
        if (!$id) {
            return false;
        }
        $user = new User();
        $user->setFlash($user->updatePassword(Yii::$app->request->post()));
        $this->redirect('my');
    }

}
