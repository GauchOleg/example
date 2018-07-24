<?php

namespace app\modules\dashboard\controllers;

use app\modules\dashboard\models\Checkbox;
use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\helpers\ArrayHelper;

class ProductDataController extends BackendController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $array =  [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
        return ArrayHelper::merge($behaviors,$array);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetCheckboxes() {

        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException;
        }
        $id = Yii::$app->request->post('catId');
        $allCheckboxes = Checkbox::getAllCheckboxesByCategoryId($id);
        if ($allCheckboxes) {
            return Json::encode($allCheckboxes);
        } else {
            return false;
        }
    }

}
