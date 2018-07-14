<?php
/* @var $orderData \app\modules\dashboard\models\Product (mixed witch model Cart) */
?>


<div class="wrapper">
    <div id="cart-view">
        <div class="container" id="cart">
            <?php echo $this->render('cart',[
                'orderData' => $orderData,
            ])?>
        </div>
    </div>
</div>