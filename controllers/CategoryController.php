<?php

namespace app\controllers;

use app\modules\dashboard\models\Category;
use app\modules\dashboard\models\Checkbox;
use app\modules\dashboard\models\Product;
use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex($id)
    {
        if ($id != Yii::$app->session->get('alias')) {
            Yii::$app->session->destroy();
        }

        $ids = Yii::$app->session->get('id');
        $checked = empty($ids) ? [null => null] : $ids;
        $category = Category::getCategoryByAlias($id);
        if (!$category) {
            throw new NotFoundHttpException();
        }
        $allCheckboxes = Checkbox::getAllCheckboxByCatId($category->id);
        $allProduct = Product::getAllProductByCategoryId($category->id);

        return $this->render('index',compact(
            'allProduct','category','allCheckboxes','checked'
        ));
    }

    public function actionView($alias) {

    }

    public function actionSortCategory() {

        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }

        $alias = Yii::$app->request->post('alias');
        $id = Yii::$app->request->post('id');
        $sessionAlias = Yii::$app->session->get('alias');
        $sessionIds = Yii::$app->session->get('id');
        $checked = [];

        if (!$sessionAlias) {
            Yii::$app->session->set('alias',$alias);
        }

        if (is_null($sessionIds)) {
            array_push($checked, $id);
            Yii::$app->session->set('id',$checked);
        } else {
            if (!in_array($id,$sessionIds)) {
                array_push($sessionIds,$id);
            } else {
                $unset = array_search($id,$sessionIds);
                unset($sessionIds[$unset]);
            }
            Yii::$app->session->set('id',$sessionIds);
        }

        $category = Category::findOne(['alias' => $alias]);
        $allProduct = Product::getAllProductByCheckboxId($checked,$category->id);
        $allCheckboxes = Checkbox::getAllCheckboxByCatId($category->id);

        return $this->renderPartial('index',compact(
            'allProduct','category','allCheckboxes','checked'
        ));
//        return Json::encode($allProduct);
    }

}
