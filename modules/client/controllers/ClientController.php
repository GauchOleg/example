<?php

namespace app\modules\client\controllers;

use Yii;
use app\modules\dashboard\searchModels\Cart;
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
    }

    public function actionHome() {

        $user = Yii::$app->user->identity;
        $countOrders = Cart::getTotalOrdersByPhone($user->metaData->phone);

        return $this->render('clients-home',[
            'user' => $user,
            'countOrders' => $countOrders,
        ]);
    }

}
