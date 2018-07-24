<?php

namespace app\modules\dashboard\controllers;

use app\modules\dashboard\models\ProductImg;
use Yii;
use app\modules\dashboard\models\Product;
use app\modules\dashboard\searchModels\ProductSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BackendController
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categoryList = $searchModel->getCategoryList();
        $productImg = new ProductImg();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryList' => $categoryList,
            'productImg' => $productImg,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $productImg = new ProductImg();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'productImg' => $productImg,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $productImg = new ProductImg();
        $categoryList = $model->getCategoryList();

        if ($model->load($post = Yii::$app->request->post()) && $model->validate() && $model->save(false)) {
            if (!empty($_FILES)) {
                $alias = $productImg->upload($_FILES,$model->id);
                if ($productImg->saveAll($alias, $model->id)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'categoryList' => $categoryList,
            'productImg' => $productImg,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $productImg = new ProductImg();
        $imgs = $productImg->checkImg($id);
        $categoryList = $model->getCategoryList();
        $checkboxesList = $model->getCheckboxesListByCategoryId();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            $alias = $productImg->upload($_FILES,$model->id);
            if ($productImg->saveAll($alias, $model->id)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'categoryList' => $categoryList,
            'imgs' => $imgs,
            'checkboxesList' => $checkboxesList,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddField() {

        if (Yii::$app->request->isPost) {
            $model = new Product();
            $productImg = new ProductImg();
            $num = Yii::$app->request->post('num');
            ($num == false) ? $num = 1 : $num = $num + 1;
            return $this->renderPartial('_add_file',compact('num','productImg','model'));
        } else {
            throw new HttpException(400);
        }
    }

    public function actionDeleteImg() {
        if (Yii::$app->request->isAjax) {
            $productImg = new ProductImg();
            $productImg->deleteByModelIdSortId(Yii::$app->request->post('modelId'),Yii::$app->request->post('id'));
            return true;
        } else {
            throw new HttpException(403);
        }
    }
}
