<?php

namespace app\controllers;

use Yii;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($alias) {

    }

}
