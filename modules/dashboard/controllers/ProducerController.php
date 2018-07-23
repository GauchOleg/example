<?php

namespace app\modules\dashboard\controllers;

use Yii;
use app\modules\dashboard\models\Producer;
use app\modules\dashboard\searchModels\Producer as ProducerSearch;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProducerController implements the CRUD actions for Producer model.
 */
class ProducerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Producer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProducerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $statusList = Producer::getStatusList();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusList' => $statusList,
        ]);
    }

    /**
     * Displays a single Producer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $statusList = Producer::getStatusList();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'statusList' => $statusList,
        ]);
    }

    /**
     * Creates a new Producer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Producer();
        $statusList = $model::getStatusList();
        $model->file = UploadedFile::getInstance($model,'file');
        if ($model->load(Yii::$app->request->post())) {
            $model->saveNewProvider();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'statusList' => $statusList,
        ]);
    }

    /**
     * Updates an existing Producer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $statusList = Producer::getStatusList();
        $model->file = UploadedFile::getInstance($model,'file');

        if ($model->load(Yii::$app->request->post())) {
            $model->saveNewProvider();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'statusList' => $statusList,
        ]);
    }

    /**
     * Deletes an existing Producer model.
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
     * Finds the Producer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Producer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeleteImage() {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException();
        }
        $post = Yii::$app->request->post();
        $producer = new Producer();
        if ($producer->deleteImage($post)) {
            return true;
        } else {
            return false;
        }
    }
}
