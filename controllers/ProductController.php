<?php

namespace app\controllers;


use Yii;
use app\modules\dashboard\models\Comment;
use app\modules\dashboard\models\Product;

class ProductController extends FrontendController
{
//    public function actionIndex()
//    {
//        return $this->render('index');
//    }

    public function actionView($alias) {

        $product = Product::getProductByAlias($alias);
        $category = Product::getCategoryByProductId($product->id);
        $comment = new Comment();
        $allComments = $comment->getAllCommentsByProductId($product->id);

        if ($comment->load(Yii::$app->request->post()) && $comment->validate()) {
            if ($comment->addComment()) {
                Yii::$app->session->setFlash('success','Ваш комментарий будет добавен полсе проверки модератором на спам');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error','Ошибка при добавлении комментария');
                return $this->refresh();
            }
        }

        return $this->render('product-view',[
            'product' => $product,
            'category' => $category,
            'comment' => $comment,
            'allComments' => $allComments,
        ]);
    }

}
