<?php

namespace app\modules\user\controllers;

use app\modules\user\models\User;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public function actionLogin() {

        $model = new User();

        return $this->render('login',[
            'model' => $model,
        ]);
    }

    public function actionCheckUserData() {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }

        $model = new User();
        if ($model->load(Yii::$app->request->post())) {
            if (!is_null($user = $model->findUserByUsername($model->username))) {
                if ($user->status == User::STATUS_APPROVED) {
                    Yii::$app->user->login($user);
                    if ($model->remember == 1) {
                        $model->setAccessToken();
                    }
                    return $this->redirect('/dashboard');
                } else {
                    Yii::$app->session->setFlash('error','Доступ к Вашему аккаунту не возможен. Обратитесь к админимстрации сайта');
                    return $this->redirect('login');
                }
            } else {
                Yii::$app->session->setFlash('error','Не верный логин/пароль',true);
                return $this->redirect('login');
            }
        }
    }

    public function actionLogout() {
        $model = new User();
        if (Yii::$app->user->identity) {
            Yii::$app->user->logout();
            $model->removeAccessToken();
            return $this->redirect('/user/default/login');
        } else {
            throw new BadRequestHttpException();
        }
    }

    public function actionAdd() {

        $role = Yii::$app->authManager->createRole('admin');
        $role->description = 'Админ';
        Yii::$app->authManager->add($role);

        $role = Yii::$app->authManager->createRole('user');
        $role->description = 'Клиент';
        Yii::$app->authManager->add($role);

        dd(123);
    }
}
