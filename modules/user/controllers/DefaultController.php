<?php

namespace app\modules\user\controllers;

use app\modules\user\models\LoginForm;
use app\modules\user\models\User;
use yii\helpers\Json;
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

        if (Yii::$app->user->can('admin')) {
            return $this->redirect('/dashboard');
        }

        if (Yii::$app->user->can('user')) {
            return $this->redirect('/client/home');
        }

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
            $response = $model->checkUserData($model);
            if ($response == 'user' || $response == 'password') {
                $model->errorUserPassword();
                return $this->redirect('/dashboard/login');
            }
            if ($response->role == User::ROLE_ADMIN && $response->status == User::STATUS_APPROVED) {
                $model->loginUser($response);
                return $this->redirect('/dashboard');
            } else {
                if ($response->status != User::STATUS_BLOCKED) {
                    $model->loginUser($response);
                    return $this->redirect('/client/home');
                } else {
                    $model->forbiddenUser();
                    return $this->redirect('/dashboard/login');
                }
            }
        }
    }

    public function actionLogout() {
        $model = new User();
        $model->logoutUser();
        return $this->redirect('/dashboard/login');
    }

    public function actionRegister() {
        $model = new LoginForm();
        $model->scenario = 'register';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($user = $model->register()) {
                Yii::$app->user->login($user);
                Yii::$app->session->setFlash('success','Спасибо за регистрацию! Добро пожаловать в Ваш личный кабинет');
                return $this->redirect('/client/settings/my');
            } else {
                Yii::$app->session->setFlash('error','Аккаунт с таким номером уже существует');
                return $this->refresh();
            }
        }

        return $this->render('register',[
            'model' => $model,
        ]);
    }

    public function actionReset() {
        $model = new LoginForm();
        $model->scenario = 'reset';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $message = Json::decode($model->resetPassword());
            $key = array_keys($message);
            $value = array_values($message);
            Yii::$app->session->setFlash($key[0],$value[0]);
            return $this->refresh();
        }
        return $this->render('reset',[
            'model' => $model,
        ]);
    }

    public function actionChangeStatus ($id){
        $model = new User();
        $user = $model->findUserById($id);
        $statusList = $user->getStatusList();
        if ($user->load(Yii::$app->request->post())) {
            $user->scenario = 'update';
            $user->update();
            return $this->redirect('/client/client/index');
        }
        return $this->renderPartial('change-status',[
            'user' => $user,
            'statusList' => $statusList,
        ]);
    }
}
