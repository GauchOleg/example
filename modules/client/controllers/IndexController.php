<?php

namespace app\modules\client\controllers;


use Yii;
use app\modules\user\models\User;

class IndexController extends \yii\web\Controller {

    public function init() {
        parent::init(); // TODO: Change the autogenerated stub

        $userId = Yii::$app->user->getId();

        switch ($userId) {
            case User::ROLE_ADMIN : return true;
                break;
            case User::ROLE_USER : return true;
                break;
            default : return $this->redirect('/dashboard/login');
        }
    }

}