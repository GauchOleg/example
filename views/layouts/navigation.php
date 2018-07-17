<?php
use yii\helpers\Url;

$url = Yii::$app->request->url;
$in_cart = $this->params['in_cart'];
?>
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a href="<?= Url::to(['site/index'])?>" class="brand">
                <img src="/frontend/images/logo.jpg" width="120" height="40" alt="Logo" />
                <!-- This is website logo -->
            </a>
            <!-- Navigation button, visible on small resolution -->
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <i class="icon-menu"></i>
            </button>
            <!-- Main navigation -->
            <div class="nav-collapse collapse pull-right">
                <ul class="nav" id="top-navigation">
                    <li class="active"><a data-id="home" href="#home">Главная</a></li>
                    <li><a data-id="catalog" href="#catalog">Категории</a></li>
                    <li><a data-id="service" href="#service">Сервис</a></li>
                    <li><a data-id="portfolio" href="#portfolio">Акция!</a></li>
<!--                    <li><a href="#about">About</a></li>-->
                    <li><a data-id="clients" href="#clients">О нас</a></li>
<!--                    <li><a href="#price">Price</a></li>-->
                    <li><a data-id="contact" href="#contact">Контакты</a></li>
                    <?php if (isset($in_cart) && !empty($in_cart)) :?>
                        <span class="badge badge-success count-products"><span id="in-cart"><?php echo $in_cart?></span></span>
                    <?php endif;?>
                    <li id="cart-button"><a data-id="cart" href="#cart"><img src="/default/img/cart.png" width="30" height="30" alt="Корзина" id="cart-img" class=""/></a></li>

<!--                    <li><i class="icon-shopping-cart"></i><a href="#">Корзина</a></li>-->
                </ul>
            </div>
            <!-- End main navigation -->
        </div>
    </div>
</div>