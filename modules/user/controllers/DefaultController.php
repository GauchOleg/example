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
}
