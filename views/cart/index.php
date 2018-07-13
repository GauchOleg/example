<?php
/* @var $orderData \app\modules\dashboard\models\Product (mixed witch model Cart) */
?>


<div class="wrapper">
    <div id="cart-view">
        <div class="container" id="cart">

            <?php if (!empty($orderData)): ?>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Код товара</th>
                        <th>Кол-во</th>
                        <th>Цена</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orderData as $item): ?>
                        <tr>
                            <td><?php echo $item['num'] ?></td>
                            <td><?php echo $item['name'] ?></td>
                            <td><?php echo $item['code'] ?></td>
                            <td><?php echo $item['count'] ?></td>
                            <td><?php echo $item['price'] ?></td>
                            <td><span class="btn btn-cart" data-product="<?php echo $item['id']?>">Удалить</span></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p> Корзина еще пуста </p>
            <?php endif; ?>

        </div>
    </div>
</div>


<script>
    $(document).ready(function () {

        $('.btn-cart').on('click', function(){
            var productId = $(this).data('product');

            $.ajax({
                url: "/cart/delete-product",
                type: "POST",
                data: {_csrf: yii.getCsrfToken(),productId: productId},
                success: function (res) {
                    console.log(res);
                },
                error: function () {
                    console.log('some error on cart controller .. ');
                }
            });
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