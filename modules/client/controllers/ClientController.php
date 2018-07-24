<?php

namespace app\modules\client\controllers;

class ClientController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
