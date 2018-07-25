<?php

namespace app\modules\client\controllers;

use app\modules\dashboard\searchModels\Cart;
use Yii;
use app\modules\user\models\searchModels\UserSearch;


class ClientController extends IndexController
{
    public function actionIndex()
    {
        if (Yii::$app->user->identity->role == UserSearch::ROLE_ADMIN) {
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('clients',[
                'dataProvider' => $dataProvider,
            ]);
        }
        $phone = Yii::$app->user->identity->metaData->phone;
        $cart = new Cart();
        $params = ['Cart' => ['customer_phone' => $phone]];
        $dataProvider = $cart->search($params);

        return $this->render('index',[
            'dataProvider' => $dataProvider,
        ]);
    }

}
