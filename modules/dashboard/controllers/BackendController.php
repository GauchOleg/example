<?php

namespace app\modules\dashboard\controllers;

use yii\web\Controller;

class BackendController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
