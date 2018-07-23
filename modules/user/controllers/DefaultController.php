<?php

namespace app\modules\user\controllers;

use app\modules\user\models\User;
use yii\web\Controller;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
//    public function actionIndex()
//    {
//        return $this->render('index');
//    }

    public function actionLogin() {

        $model = new User();
        return $this->render('login',[
            'model' => $model,
        ]);
    }
}
