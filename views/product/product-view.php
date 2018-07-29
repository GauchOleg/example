<?php
/* @var $category \app\modules\dashboard\models\Category */
/* @var $product \app\modules\dashboard\models\Product */
/* @var $comment \app\modules\dashboard\models\Comment */
/* @var $allComments \app\modules\dashboard\models\Comment @type array (all comments)*/
?>
<div class="wrapper">
    <div id="cart-product">
        <div class="container" id="catalog">
            <?php echo $this->render('product',[
                'category'  => $category,
                'product'   => $product,
                'comment' => $comment,
                'allComments' => $allComments,
            ]);?>
        </div>
    </div>
</div>