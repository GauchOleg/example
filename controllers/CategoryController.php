<?php

namespace app\controllers;

use app\modules\dashboard\models\Category;
use app\modules\dashboard\models\Checkbox;
use app\modules\dashboard\models\Product;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use Yii;

class CategoryController extends FrontendController
{
    const PER_PAGE = 9;

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
        $query = Product::getAllProductByCheckboxId($checked, $category->id,true);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => self::PER_PAGE, 'pageSizeParam' => false, 'forcePageParam' => false]);
        $allProduct = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $allCategory = Category::find()->all();

        return $this->render('index',
            [
                'allProduct'    => $allProduct,
                'category'      => $category,
                'allCheckboxes' => $allCheckboxes,
                'checked'       => $checked,
                'allCategory'   => $allCategory,
                'pages' => $pages,
                'query' => $query,
            ]);
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
        $query = Product::getAllProductByCheckboxId($checked, $category->id,true);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(),'pageSize' => self::PER_PAGE, 'pageSizeParam' => false, 'forcePageParam' => false]);

        $allCheckboxes = Checkbox::getAllCheckboxByCatId($category->id);
        $allCategory = Category::find()->all();
        $allProduct = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->renderPartial('catalog',
            [
                'allProduct'    => $allProduct,
                'category'      => $category,
                'allCheckboxes' => $allCheckboxes,
                'checked'       => $checked,
                'allCategory'   => $allCategory,
                'pages' => $pages,
                'query' => $query,
            ]);
    }

}
