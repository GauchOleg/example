<?php

namespace app\modules\client\controllers;


use Yii;
use app\modules\user\models\User;
use yii\filters\AccessControl;

class IndexController extends \yii\web\Controller {

    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin','user'],
                        'denyCallback' => function ($rule, $action) {
                            throw new \Exception('Permissions denied');
                        }
                    ],
                ],
            ],
        ];
    }

}