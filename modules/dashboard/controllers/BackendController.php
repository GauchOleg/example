<?php

namespace app\modules\dashboard\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class BackendController extends Controller
{

//    public function behaviors() {
//
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['admin', 'admin-did', 'admin-mcb', 'admin-all'],
//                        'denyCallback' => function ($rule, $action) {
//                            throw new \Exception('Permissions denied');
//                        }
//                    ],
//                ],
//            ],
//        ];
//    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
