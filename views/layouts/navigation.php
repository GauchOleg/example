<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

$url = Yii::$app->request->url;
$in_cart = $this->params['in_cart'];
$search = $this->params['search'];
$allProduct = $this->params['allProduct'];
//dd($allProduct)
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
            <div class="row">
                <div class="span12">
                    <?php $form = ActiveForm::begin([
                        'action' => '/site/search',
                        'method' => 'get',
                    ]); ?>

                    <?php echo $form->field($search, 'search')->widget(\yii\jui\AutoComplete::classname(), [
                        'clientOptions' => [
                            'source' => Url::to(['site/auto-complete-search']),
                            'minLength' => 3,
//                            'autoFill' => true,
                            'select'=> new \yii\web\JsExpression("function( event, ui ){
                                window.location = '/search?q=' + encodeURIComponent(ui.item.value);
                                }")
                        ],
                    ])->textInput(['maxlength' => true, 'placeholder'=>'Поиск по названию...'])->label('');
                    ?>

<!--                        --><?php //echo $form->field($search,'search')->textInput()->input('text', ['placeholder' => "Поиск по товарам"])->label(false)?>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>