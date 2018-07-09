<?php

namespace app\controllers;

use app\modules\dashboard\models\Category;
use app\modules\dashboard\models\Checkbox;
use app\modules\dashboard\models\Product;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        $category = Category::getCategoryByAlias($id);
        if (!$category) {
            throw new NotFoundHttpException();
        }
        $allCheckboxes = Checkbox::getAllCheckboxByCatId($category->id);
        $allProduct = Product::getAllProductByCategoryId($category->id);

        return $this->render('index',compact(
            'allProduct','category','allCheckboxes'
        ));
    }

    public function actionView($alias) {

    }

    public function actionSortCategory() {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }
        $id = Yii::$app->request->post('id');
        $allProduct = Product::getAllProductByCheckboxId($id);
//        Yii::$app->session->set('id',$id);
//        dd($allProduct);
        return Json::encode($allProduct);
    }

}
