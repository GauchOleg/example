<?php

/* @var $this yii\web\View */

$this->title = 'Страница благодарности'
?>
<div class="wrapper">
    <div id="cart-view">
        <div class="container center" id="cart" style="padding-top: 100px;">
            <p style="color: #ffcf00">Спасибо! Ваш заказ принят. </p>
        </div>
    </div>
</div>

<script>
    $('[data-id="home"]').attr('href','/');
    $('[data-id="home"]').parent('li').removeClass('active');
    $('[data-id="catalog"]').attr('href','/#catalog');
    $('[data-id="cart"]').parent('li').addClass('active');

    $('[data-id="service"]').attr('href','/#service');
    $('[data-id="portfolio"]').attr('href','/#portfolio');
    $('[data-id="clients"]').attr('href','/#clients');
    $('[data-id="contact"]').attr('href','/#contact');
    $('[data-id="cart"]').attr('href','/cart');
    $('[data-id="cart"]').parent('li').addClass('active');
</script>