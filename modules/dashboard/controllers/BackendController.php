<?php

namespace app\modules\dashboard\controllers;

class BackendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
