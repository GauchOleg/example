<?php

namespace app\modules\dashboard\controllers;

use Yii;
use app\modules\dashboard\models\MetaData;

class ContentController extends BackendController
{
    public function actionIndex()
    {
        $meta = new MetaData();
        $metaData = $meta->getAllData();

        if (Yii::$app->request->isPost) {
            if ($meta->updateMetaData(Yii::$app->request->post())) {
                Yii::$app->session->setFlash('success',MetaData::SUCCESS_MESSAGE);
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error',MetaData::ERROR_MESSAGE);
            }
        }

        return $this->render('index',[
            'model' => $meta,
            'metaData' => $metaData,
        ]);
    }

}
