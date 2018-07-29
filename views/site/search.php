<?php
/* @var $products \app\modules\dashboard\models\Product*/

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>


<div class="section primary-section catalog-section" id="cart-view">
    <div class="container">

        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $products,
            'tableOptions' => ['class' => 'table  table-bordered'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'category_id',
                    'value' => function($model){
                        return $model->getCategoryLink();
                    },
                    'format' => 'raw',
                    'filter' => $categoryList
                ],
                [
                    'attribute' => 'name',
                    'value' => function($model){
                        return $model->getLinkName();
                    },
                    'format' => 'raw',
                ],
                'code',
                [
                    'attribute' => 'images',
                    'value' => function($model) use ($productImg) {
                        return $productImg->getImg($model->id,false,false,'cart');
                    },
                    'format' => 'raw'

                ],
                [
                    'headerOptions' => ['style' => 'width:50px'],
                    'attribute' => 'new',
                    'value' => function($model) {
                        return $model->checkNew();
                    },
                    'format' => 'raw',
                ],
                [
                    'headerOptions' => ['style' => 'width:50px'],
                    'attribute' => 'sale',
                    'value' => function($model) {
                        return $model->checkSale();
                    },
                    'format' => 'raw',
                ],
                [
                    'headerOptions' => ['style' => 'width:50px'],
                    'attribute' => 'price',
                    'value' => function($model) {
                        return $model->getPriceInView();
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'add_to_cart',
                    'value' => function($model){
                        return $model->addToCart();
                    },
                    'format' => 'raw',
                ]
            ],
        ]);
    ?>
        <?php Pjax::end(); ?>
    </div>
</div>

<script>
    $(".add-cart").on('click', function () {
        var count = 1;
        var id = $(this).data('id');
        $.ajax({
            url: "/cart/add-to-cart",
            data: {'id' : id,'count': count,'_csrf' : yii.getCsrfToken()},
            type: "POST",
            success: function(res){
                var icon = "<span class='badge badge-success count-products'><span id='in-cart'>"+ res +"</span></span>";
                $('#cart-button').before(icon);
                $('#cart-img').addClass( "wibro" );
                setTimeout(deleteClass,500);
            },
            error: function(){

            }
        });
        return false;
    });

    function deleteClass(){
        $('#cart-img').removeClass( "wibro" );
    }

    $('[data-id="home"]').attr('href','/');
    $('[data-id="home"]').parent('li').removeClass('active');
    $('[data-id="catalog"]').attr('href','/#catalog');

    $('[data-id="service"]').attr('href','/#service');
    $('[data-id="portfolio"]').attr('href','/#portfolio');
    $('[data-id="clients"]').attr('href','/#clients');
    $('[data-id="contact"]').attr('href','/#contact');
    $('[data-id="cart"]').attr('href','/cart');

</script>