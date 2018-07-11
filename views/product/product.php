<?php
/* @var $this yii\web\View */
/* @var $category \app\modules\dashboard\models\Category */
/* @var $product \app\modules\dashboard\models\Product */

use app\modules\dashboard\models\Product;
use app\modules\dashboard\models\ProductImg;
use app\modules\dashboard\models\Checkbox;
use yii\helpers\Html;
use yii\helpers\Url;

if (isset($product) && !empty($product)) {
    $this->title = $product->name;

    $this->registerMetaTag([
        'name' => 'title',
        'content' => $product->seo_title,
    ]);
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $product->seo_keywords,
    ]);
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $product->seo_description,
    ]);
}

?>
<div id="content">
    <input id="cat_alias" type="hidden" name="alias" value="<?php echo $category->alias; ?>">
    <div class="row">
        <div class="span12 category-title">
            главная -> <?php echo $category->name?> -> <?php echo $product->name?>
        </div>
    </div>
    <div class="row">
        <div class="span4">
            <p>Код товара: <?php echo $product->code;?></p>
        </div>
        <div class="span8">
            <h1><?php echo $product->name;?></h1>
        </div>
    </div>
    <div class="row">
        <div class="span4">
            <div>
                <a href="<?php echo ProductImg::getLinkImgByProductId($product->id)?>" class="product-img">
                    <?php echo ProductImg::getImgByProductId($product->id,true)?>
                </a>
            </div>
<!--            --><?php //dd($product)?>
        </div>
        <div class="span8">
            <div class="cart-field">
                <div class="description-product">
                    <?php echo Product::checkSaleNewOption($product); ?>
                    <p class="product-label"><span class="product-property">Название:</span> <?php echo $product->name;?></p>
                    <p class="product-label"><span class="product-property">Категория:</span> <?php echo Html::a($category->name,['/category', 'id' => $category['alias']],['class' => 'product-label']);?></p>
                    <p class="product-label"><span class="product-property">Код:</span> <?php echo $product->code;?></p>
                    <p class="product-label"><span class="product-property">Цена:</span> <?php echo Product::getPrice($product)?></p>
                    <span class="button-count">
                        <a href="#" id="minus" class="btn count-product">-</a>
                        <input id="count" class="form-control" name="quantity" type="text" value="1" />
                        <a href="#" id="plus" class="btn count-product">+</a>
                    </span>
                    <span class="btn button-cart">Добавить в корзину</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#minus').on('click', function(){
            var count = $('#count').val();
            if (count == 1) {
                return false;
            } else {
                $('#count').val(count-1);
                $('#minus').css({'background':0,'color':'white'});
            }
            console.log(count);
            return false;
        });

        $("#plus").on('click', function () {
            var count = parseInt($('#count').val());
            $('#count').val(count+1);
            $('#plus').css({'background':0,'color':'white'});
            return false;
        });

        $('.product-img').magnificPopup({
            type: 'image',
            mainClass: 'mfp-with-zoom', // this class is for CSS animation below

            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                // The "opener" function should return the element from which popup will be zoomed in
                // and to which popup will be scaled down
                // By defailt it looks for an image tag:
                opener: function(openerElement) {
                    // openerElement is the element on which popup was initialized, in this case its <a> tag
                    // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });

        $('[data-id="home"]').attr('href','/');
        $('[data-id="home"]').parent('li').removeClass('active');
        $('[data-id="catalog"]').attr('href','/#catalog');
        $('[data-id="catalog"]').parent('li').addClass('active');

        $('[data-id="service"]').attr('href','/#service');
        $('[data-id="portfolio"]').attr('href','/#portfolio');
        $('[data-id="clients"]').attr('href','/#clients');
        $('[data-id="contact"]').attr('href','/#contact');
    })
</script>