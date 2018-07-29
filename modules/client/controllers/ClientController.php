<?php

namespace app\modules\client\controllers;

use app\modules\user\models\User;
use Yii;
use app\modules\dashboard\searchModels\Cart;
use app\modules\user\models\searchModels\UserSearch;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;


class ClientController extends IndexController
{
    public function actionIndex()
    {
//        dd(UserMeta::find()->where(['user_id' => 3])->asArray()->indexBy('meta_key')->all()['image']['meta_value']);
        if (Yii::$app->user->identity->role == UserSearch::ROLE_ADMIN) {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('clients',[
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionHome() {

        $user = Yii::$app->user->identity;
        if  (empty($user->metaData->phone)) {
            Yii::$app->session->setFlash('error','Профиль не найден',true);
            Yii::$app->user->logout($user);
            return $this->redirect('/dashboard/login');
        }
        $countOrders = Cart::getTotalOrdersByPhone($user->metaData->phone);

        return $this->render('clients-home',[
            'user' => $user,
            'countOrders' => $countOrders,
        ]);
    }

    public function actionView($id) {
        if (Yii::$app->user->identity->role != UserSearch::ROLE_ADMIN) {
            throw new ForbiddenHttpException();
        }
        return $this->renderPartial('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id) {
        $identity = Yii::$app->user->identity;
        if (is_null($identity) || !$identity || $identity->role != User::ROLE_ADMIN) {
            throw new ForbiddenHttpException();
        }
        $user = new User();
        $user->deleteAllUserData($id);
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success','Пользователь был успешно удален');
        return $this->redirect('/client/client/index');
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = \app\modules\user\models\User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
