<?php

namespace app\controllers;

use app\modules\dashboard\models\Product;

class ProductController extends FrontendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($alias) {

        $product = Product::getProductByAlias($alias);
        $category = Product::getCategoryByProductId($product->id);

        return $this->render('product-view',[
            'product' => $product,
            'category' => $category,
        ]);
    }

}
