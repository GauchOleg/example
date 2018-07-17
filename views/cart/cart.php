<?php
/* @var $orderData \app\modules\dashboard\models\Product (mixed witch model Cart) */
/* @var $model \app\modules\dashboard\models\Product (mixed witch model Cart) */

use yii\helpers\Url;
use app\modules\dashboard\models\Cart;
use yii\helpers\Html;
?>

<div id="content">
    <?php if (!empty($orderData)): ?>
        <?php $form = \yii\widgets\ActiveForm::begin([
            'id' => 'order-form',
            'enableClientValidation' => true,
            'action' => 'cart/order'
        ])?>
        <p class="in-cart"> В корзине: </p>
        <table class="table" id="cart-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Название</th>
                <th>Код товара</th>
                <th>Фото</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orderData as $item): ?>
                <tr>
                    <td><?php echo $item['num'] ?></td>
                    <td><a href="<?php echo Url::to(['product/view','alias' => $item['alias']])?>" class="cart-link"><?php echo $item['name'] ?></a></td>
                    <td><?php echo $item['code'] ?></td>
                    <td><?php echo $item['img'] ?></td>
                    <td>
                        <span class="button-count">
                            <a href="#" data-id="<?php echo $item['id']?>" class="minus btn count-product">-</a>
                            <span class="prod-cunt">
                                <input id="<?php echo $item['id']?>" class="form-control count" name="quantity" type="text" value="<?php echo $item['count'] ?>" />
                            </span>
                            <a href="#" data-id="<?php echo $item['id']?>" class="plus btn count-product">+</a>
                        </span>
                    </td>
                    <td data-prices="<?php echo $item['id']?>" data-price="<?php echo $item['price']?>" id="price-id-<?php echo $item['id']?>"><?php echo $item['price'] * $item['count'] ?> грн.</td>
                    <td><span class="btn btn-cart" data-product="<?php echo $item['id']?>">Удалить</span></td>
                    <?php echo Html::hiddenInput('product_id['. $item['id'].']',$item['id']) ?>
                    <?php echo Html::hiddenInput('product_code['. $item['id'].']',$item['code']) ?>
                    <?php echo Html::hiddenInput('count['. $item['id'].']',$item['count']) ?>
                    <?php echo Html::hiddenInput('prices['. $item['id'].']',$item['price']) ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <div class="row">
            <div class="span12">
                <p class="pull-right" style="color: yellow">Всего на сумму: <span id="total"><?php echo Cart::getTotalPrice($orderData)?></span></p>
                <?php echo Html::hiddenInput('total_price',Cart::getTotalPrice($orderData),['id' => 'model-total']) ?>
            </div>
        </div>
        <div class="row">
            <div class="span4">
                <?php echo $form->field($model,'customer_l_name')->input('text')?>
                <?php echo $form->field($model,'customer_name')->input('text')?>
                <?php echo $form->field($model,'customer_o_name')->input('text')?>
            </div>
            <div class="span4">
                <?php echo $form->field($model,'customer_phone')->input('text')?>
                <?php echo $form->field($model,'delivery')->dropDownList(Cart::getDeliveryList(),['prompt' => '-- Выбрать --'])?>
                <?php echo $form->field($model,'address')->input('text')?>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <?php echo Html::submitButton('Отправить',['class' => 'pull-right btn btn-cart-order'])?>
            </div>
        </div>
<!--        <p><button type="submit" class="pull-right btn btn-cart-order">Оформить заказ</button></p>-->
        <?php \yii\widgets\ActiveForm::end()?>
    <?php else: ?>
        <p class="center" style="padding-top: 100px; color: #ffcf00"> Корзина пуста </p>

    <?php endif; ?>
</div>


<script>
    $(document).ready(function () {

        $('.btn-cart-order').on('click', function () {
            $(this).css({'background':'black'});
        });

        $(".field-cart-address").css({'display':'none'});

        $('#cart-delivery').on('change',function () {
            var selectVal = $(this).val();
            if (selectVal != 1) {
                $(".field-cart-address").css({'display':''});
            } else {
                $(".field-cart-address").css({'display':'none'});
            }
        });


        $('.btn-cart').on('click', function(){
            var productId = $(this).data('product');

            $.ajax({
                url: "/cart/delete-product",
                type: "POST",
                data: {_csrf: yii.getCsrfToken(),productId: productId},
                success: function (res) {
                    if (res) {
                        var val = parseInt($('#in-cart').html()) - 1;
                        $('#in-cart').html(val);
                        $('#content').html(res);
                    }
                },
                error: function () {
                    console.log('some error on cart controller .. ');
                }
            });
        });

        $('.minus').on('click', function(){

            var id = $(this).data('id').valueOf();
            var price = $('[data-prices="'+ id +'"]').attr('data-price').valueOf();
            var count = parseInt($("#"+id).val());
            if (count == 1) {
                return false;
            } else {
                count = count - 1;
                $("#"+id).val(count);
                var newPrice = count * price;
                $("#price-id-"+ id).html(newPrice + ' грн.');

                var oldTotal = parseInt($("#total").html());
                var newTotal = parseInt(oldTotal - price);
                $("#total").html(newTotal + ' грн.');
                $("#model-total").val(newTotal);
                $($.find('input[name="count['+ id +']"]')).val(count);

                $('.minus').css({'background':0,'color':'white'});
                return false;
            }
            return false;
        });

        $(".plus").on('click', function () {
            var id = $(this).data('id').valueOf();
            var price = $('[data-prices="'+ id +'"]').attr('data-price').valueOf();
            var count = parseInt($("#"+id).val()) + 1;
            $("#"+id).val(count);
            $("#price-id-"+ id).html((count * price) + ' грн.');

            var oldTotal = parseInt($("#total").html());
            var newTotal = Number(oldTotal) + Number(price);
            $("#total").html(newTotal + ' грн.');
            $("#model-total").val(newTotal);
            $($.find('input[name="count['+ id +']"]')).val(count);

            $('.plus').css({'background':0,'color':'white'});
            return false;
        });

        $('[data-id="home"]').attr('href','/');
        $('[data-id="home"]').parent('li').removeClass('active');
        $('[data-id="catalog"]').attr('href','/#catalog');
        $('[data-id="cart"]').parent('li').addClass('active');

        $('[data-id="service"]').attr('href','/#service');
        $('[data-id="portfolio"]').attr('href','/#portfolio');
        $('[data-id="clients"]').attr('href','/#clients');
        $('[data-id="contact"]').attr('href','/#contact');
        $('[data-id="cart"]').attr('href','#cart');
        $('[data-id="cart"]').parent('li').addClass('active');
    });
</script>
