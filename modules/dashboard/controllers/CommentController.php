<?php

namespace app\modules\dashboard\controllers;

use app\modules\dashboard\models\Comment;
use Yii;
use app\modules\dashboard\searchModels\CommentSearch;
use yii\web\NotFoundHttpException;

class CommentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdateStatus($id) {

        $model = new Comment();
        $statusList = $model->getStatusList();
        $comment = $model->getCommentById($id);

        if ($comment->load(Yii::$app->request->post())) {
//            $user->scenario = 'update';
            $comment->update();
            return $this->redirect('/dashboard/comment/index');
        }

        return $this->renderPartial('update',[
            'comment' => $comment,
            'statusList' => $statusList,
        ]);
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException();
    }

}
