<?php
/* @var $this yii\web\View */
/* @var $category \app\modules\dashboard\models\Category */
/* @var $allProduct \app\modules\dashboard\models\Product */
/* @var $allCheckboxes \app\modules\dashboard\models\Checkbox */
/* @var $checked \app\modules\dashboard\models\Checkbox */

use app\modules\dashboard\models\Product;
use app\modules\dashboard\models\ProductImg;
use app\modules\dashboard\models\Checkbox;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\grid\GridView;


if (isset($category) && !empty($category)) {
    $this->title = $category->name;

    $this->registerMetaTag([
        'name' => 'title',
        'content' => $category->seo_title,
    ]);
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $category->seo_keywords,
    ]);
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $category->seo_description,
    ]);
}

?>
<div id="content">
    <input id="cat_alias" type="hidden" name="alias" value="<?php echo $category->alias; ?>">
    <div class="row">
        <div class="col-md-12 center category-title">
            <h4><?php echo $category->name?></h4>
        </div>
    </div>
    <div class="row">
        <div class="span3">
            <?php if (isset($allCheckboxes) && !empty($allCheckboxes)) :?>
                <p>Фильтры:</p>
                <ul class="checkbox-menu">
                    <?php foreach ($allCheckboxes as $checkbox): ?>
                        <li>
                            <label class="checkbox">
                                <span class="checkbox-name"><input class="checked" type="checkbox" value="<?php echo $checkbox->id?>" <?php echo Checkbox::checkChecked($checkbox->id,$checked) ? 'checked' : '' ?> > <?php echo $checkbox->name; ?></span>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if (isset($allCategory) && !empty($allCategory)) :?>
                <p>Категории:</p>
                <ul class="checkbox-menu">
                    <?php foreach ($allCategory as $category): ?>
                        <li>
                            <span class="checkbox-name">
                                - <?php echo Html::a($category->name,['/category', 'id' => $category->alias])?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php if (isset($allProduct) && !empty($allProduct)): ?>
        <div class="span9" id="product">
            <?php $countProduct = 0;?>
            <?php foreach ($allProduct as $product): ?>
        <?php if ($countProduct == 0): ?>
        <div class="row">
        <?php endif;?>
        <?php if ($countProduct % 3 == 0): ?>
        </div><div class="row">
                <?php endif;?>
                <div class="span3 pb-3">
                    <div class="thumbnail product-cart">
                        <a href="<?php echo ProductImg::getImg($product->id,false,true,'catalog')?>" class="product-img">
                            <?php echo ProductImg::getImg($product->id,false,false,'catalog')?>
                        </a>

                        <div class="caption cart-product-title">
                            <h3><?php echo $product->name?></h3>
                            <p><?php echo $product->small_text; ?></p>
                            <span class="price"><?php echo Product::getPrice($product)?></span>
                            <p><a href="<?php echo Url::to(['product/view','alias' => $product->alias])?>" class="btn did btn-outline">Просмотр</a> <a href="#" class="btn btn-outline did cart" data-id="<?php echo $product->id?>">В корзину</a></p>
                        </div>
                    </div>
                </div>
                <?php $countProduct++;?>
                <?php endforeach; ?>
            </div>
            <?php else :?>
                <p class="center">В категории еще нет товаров</p>
            <?php endif;?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

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

        $(".cart").on('click', function () {
            var count = 1;
            var id = $(this).data('id');
            $.ajax({
                url: "/cart/add-to-cart",
                data: {'id' : id,'count': count,'_csrf' : yii.getCsrfToken()},
                type: "POST",
                success: function(res){
                    var icon = "<span class='badge badge-success count-products'><span id='in-cart'>"+ res +"</span></span>";
                    $('#cart-button').before(icon);
                },
                error: function(){

                }
            });
            return false;
        });

        $('.checked').on('click', function(){
            var id = $(this).val();
            var alias = $('#cat_alias').val();
            $.ajax({
                url: 'sort-category',
                data: {_csrf: yii.getCsrfToken(),id: id,alias: alias},
                type: 'POST',
                success: function(res) {
                    if (res) {
                        $('#content').html(res);
                        return false;
                    }
                },
                error: function() {
                    console.log('error');
                }
            });
        });

        $('[data-id="home"]').attr('href','/');
        $('[data-id="home"]').parent('li').removeClass('active');
        $('[data-id="catalog"]').attr('href','/#catalog');
        $('[data-id="catalog"]').parent('li').addClass('active');

        $('[data-id="service"]').attr('href','/#service');
        $('[data-id="portfolio"]').attr('href','/#portfolio');
        $('[data-id="clients"]').attr('href','/#clients');
        $('[data-id="contact"]').attr('href','/#contact');
        $('[data-id="cart"]').attr('href','/cart');

    })
</script>