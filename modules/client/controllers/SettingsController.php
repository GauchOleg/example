<?php

namespace app\modules\client\controllers;


use app\modules\user\models\LoginForm;
use app\modules\user\models\UserMeta;
use Yii;
use app\modules\dashboard\models\Cart;
use app\modules\user\models\User;
use yii\web\BadRequestHttpException;

class SettingsController extends IndexController
{

    public function actionMy() {
        $identity = Yii::$app->user->identity;
        $id = $identity->getId();
        $user = User::find()->where(['id' => $id])->one();
        $countOrders = Cart::getTotalOrdersByPhone($identity->metaData->phone);
        $meta = UserMeta::find()->where(['user_id' => $id])->asArray()->indexBy('meta_key')->all();
        $model = new UserMeta();

        return $this->render('my',[
            'user' => $user,
            'countOrders' => $countOrders,
            'meta' => $meta,
            'model' => $model,
        ]);
    }

    public function actionUpdateProfile() {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        $meta = new UserMeta();
        $meta->updateMetaData(Yii::$app->request->post());
        Yii::$app->session->setFlash('success','Данные обновлены');
        return $this->redirect('my');
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

    public function actionUpdateImage() {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        $userMata = new UserMeta();
        if ($userMata->uploadImage(Yii::$app->request->post())) {
            Yii::$app->session->setFlash('success','Аватар успешно обновлен',true);
        } else {
            Yii::$app->session->setFlash('error','Аватар не обновлен',true);
        }
        return $this->redirect('my');
    }

    public function actionDeleteImg() {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }
        $userMata = new UserMeta();
        if ($userMata->deleteImageByUserId(Yii::$app->request->post())) {
            return true;
        } else {
            return false;
        }
    }

}
