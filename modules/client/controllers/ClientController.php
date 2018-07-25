<?php

namespace app\modules\client\controllers;

use Yii;
use app\modules\user\models\searchModels\UserSearch;


class ClientController extends IndexController
{
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin')) {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('clients',[
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('index');
    }

}
