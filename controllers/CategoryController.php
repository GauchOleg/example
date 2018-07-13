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

class CategoryController extends FrontendController
{
    public function actionIndex($id) {
        if ($id != Yii::$app->session->get('alias')) {
            Yii::$app->session->remove('alias');
            Yii::$app->session->remove('id');
        }

        $checked = Yii::$app->session->get('id');
        $category = Category::getCategoryByAlias($id);
        if (!$category) {
            throw new NotFoundHttpException();
        }

        $allCheckboxes = Checkbox::getAllCheckboxByCatId($category->id);
        $allProduct = Product::getAllProductByCheckboxId($checked, $category->id);
        $allCategory = Category::find()->all();

        return $this->render('index',
            [
                'allProduct'    => $allProduct,
                'category'      => $category,
                'allCheckboxes' => $allCheckboxes,
                'checked'       => $checked,
                'allCategory'   => $allCategory,
            ]);
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
        $checked = Product::getCheckedCheckbox($sessionIds,$id);

        if (!$sessionAlias) {
            Yii::$app->session->set('alias',$alias);
        }

        Yii::$app->session->set('id',$checked);

        $category = Category::getCategoryByAlias($alias);
        $allProduct = Product::getAllProductByCheckboxId($checked, $category->id);
        $allCheckboxes = Checkbox::getAllCheckboxByCatId($category->id);
        $allCategory = Category::find()->all();

        return $this->renderPartial('catalog',
            [
                'allProduct'    => $allProduct,
                'category'      => $category,
                'allCheckboxes' => $allCheckboxes,
                'checked'       => $checked,
                'allCategory'   => $allCategory,
            ]);
    }

}
