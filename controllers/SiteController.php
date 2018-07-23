<?php

namespace app\controllers;

use app\modules\dashboard\models\Category;
use app\modules\dashboard\models\MetaData;
use app\modules\dashboard\models\Producer;
use app\modules\dashboard\models\Product;
use app\modules\dashboard\models\ProductImg;
use app\modules\dashboard\models\Slider;
use app\modules\dashboard\searchModels\ProductSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\Json;

class SiteController extends FrontendController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $meta = new MetaData();
        $allCategory = Category::getAllCategory();
        $allSliders = Slider::getAllActiveSliders();
        $metaData = $meta->getAllData();
        $saleProduct = Product::getProductOnIndexPage();
        $imgs = Product::getImgByProductId($saleProduct);
        $producers = Producer::getAllActiveProducers();

        return $this->render('index',[
            'allCategory' => $allCategory,
            'allSliders' => $allSliders,
            'metaData' => $metaData,
            'saleProduct' => $saleProduct,
            'imgs' => $imgs,
            'producers' => $producers,
        ]);
    }

    public function actionCatalog() {
        $allCategory = Category::getAllCategory();

        return $this->render('catalog',[
                'allCategory' => $allCategory,
            ]);
    }

    public function actionProducer($id) {
        $producer = new Producer();
        $model = $producer->getProducerById($id);

        return $this->render('producer-view',[
            'model' => $model,
        ]);
    }

    public function actionSearch() {

        if (Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
//        dd(Yii::$app->request->get());
        $search = new ProductSearch();
        $products = $search->searchByProduct(Yii::$app->request->get());
        $categoryList = Category::getAllCategory();
        $productImg = new ProductImg();

        return $this->render('search',[
            'products' => $products,
            'categoryList' => $categoryList,
            'productImg' => $productImg,
        ]);

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAutoCompleteSearch() {
        $term = Yii::$app->request->get('term');

        $data = Product::find()
            ->select(['name as value', 'name as  label'])
            ->where(['like', 'name', $term])
            ->limit(10)
            ->asArray()
            ->all();
        echo Json::encode($data);
    }
}
