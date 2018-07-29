<?php
/* @var $this yii\web\View */
/* @var $category \app\modules\dashboard\models\Category */
/* @var $item$product \app\modules\dashboard\models\Product */
/* @var $comment \app\modules\dashboard\models\Comment */
/* @var $allComments \app\modules\dashboard\models\Comment @type array (all comments)*/

use app\modules\dashboard\models\Product;
use app\modules\dashboard\models\ProductImg;
use app\modules\dashboard\models\Checkbox;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
$user_id = isset(Yii::$app->user->identity) ? Yii::$app->user->identity->getId() : null;
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <!--        <h4>Сохранено!</h4>-->
        <i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-error alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>Ошибка!</h4>
        <i class="icon fa fa-warning"></i> <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<div id="content">
    <input id="cat_alias" type="hidden" name="alias" value="<?php echo $category->alias; ?>">
    <input id="product_id" type="hidden" name="product_id" value="<?php echo $product->id; ?>">
    <div class="row">
        <div class="span12 category-title">
            <?php echo Product::getBredCrumbs($product);?>
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
                <a href="<?php echo ProductImg::getImg($product->id,false,true,'product')?>" class="product-img">
                    <?php echo ProductImg::getImg($product->id,false,false,'product')?>
                </a>
                    <?php foreach (ProductImg::getGalleryImageByProductId($product->id) as $item): ?>
                        <span class="media">
                            <a class="pull-left product-img" href="<?php echo Yii::getAlias('@web') . $item['alias']?>" >
                                <?php echo ProductImg::getImg(false,$item['id'],false,'gallery') ?>
                            </a>
                        </span>
                    <?php endforeach;?>
            </div>
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
    <div class="row">
        <div class="span12">
            <div class="product-description">
                <snan class="tab-title" data-id="reviews"> Отзывы </snan>
                <snan class="tab-title activate" data-id="product-descripton" activate"> Описание </snan>
                <div id="product-descripton">
                    <h3><?php echo mb_strtoupper($product->name)?></h3>
                    <?php echo $product->text?>
                </div>
                <div id="reviews">
                    <?php if (!empty($allComments)) : ?>
                        <?php foreach ($allComments as $comment) :?>
                            <div class="media">
                                <a class="pull-left" href="#">
                                    <img class="media-object" data-src="holder.js/64x64" alt="64x64" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACiUlEQVR4Xu2Y64tpYRTGH4Pk8p0h90vxbUhJ/nghGddBTC7f5BK5q1FDTmvV6Eynxpm9R6Os98uOl/Xu51mXH1uzWCxOuOOlEQOkAqQFZAbc8QyEDEGhgFBAKCAUEArcsQOCQcGgYFAwKBi8YwjInyHBoGBQMCgYFAwKBu/YAdUYfH9/R7vdxnw+h16vh9/vh91u/2Rpq9XCeDyG1+vl/a/WT8e7lFvVBjQaDRbvcrn4ut1ukUqlYDAY+Oz1eo1yuYzT6fRfBvx0vKsaQNnKZDLweDzw+Xw4Ho/QaDTQarXnc4vFIkwmEyaTydmAarWKzWaDZDIJnU6HQqHA34tGo8jlct+Od0nkV/uqKmC1WnF2Hx8fMZvNOMtOpxOBQIDPHA6H6Pf7iMfjyOfzZwPe3t5YtNVqhdlsRq/X48/Q95XE+zUDSHS9XucMk2gSTG1AYkgYiaaeJ6HpdPpTCwwGA3Q6Ha4Wh8OBUCjEJiqNp9QEVRVAYmu1GoLBINxuN/d7qVRiMfv9HovFArFYjFuDSpvmBBlCog+HA7LZLO8lEglYLBY2T2m8XzGARH4II9HL5RKVSgXhcBiU4d1u9899ESEikQi63S5GoxHPAKqWp6cnNk1pvF8xgA6lniWhNAin0ylTgIYbDUjKLi26vry8wGazcRtQ9qlSqG2MRiOazSabQuYoiUcGKl2qWoAOpay9vr5y9kkM0YB6/u9Fgj9mABnw/PzMA49K/+HhgauGTKTX9P534l36XXHJGNUGXDrg1vfFAHkgIg9E5IGIPBC59Ul9zfsTCggFhAJCAaHANafsrccWCggFhAJCAaHArU/qa96fUEAoIBQQCggFrjllbz22UEAocOcU+ANVWYGfbgXFLAAAAABJRU5ErkJggg==" style="width: 64px; height: 64px;">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $comment['username']?></h4>
                                    <?php echo $comment['text']?>
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php else: ?>
                        <h4>Еще нет коментариев к этому товару</h4>
                    <?php endif; ?>

                    <?php $form = ActiveForm::begin()?>
                        <div class="reviews">
                            <?php echo $form->field($comment,'text')->textarea(['rows' => 3,'value' => ''])->label('Коментарий')?>
                            <?php echo Html::hiddenInput('Comment[product_id]',$product->id)?>
                            <?php echo Html::hiddenInput('Comment[user_id]',$user_id)?>
                            <?php echo Html::submitButton('Отправить',['class' => 'btn button-reviews'])?>
                        </div>
                    <?php ActiveForm::end()?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('.button-cart').on('click', function () {
            var product_id = $('#product_id').val();
            var count = $('#count').val();
            
            $.ajax({
                url: "/cart/add-to-cart",
                data: {'id' : product_id,'count': count,'_csrf' : yii.getCsrfToken()},
                type: "POST",
                success: function(res){
                    if (res) {
                        var icon = "<span class='badge badge-success count-products'><span id='in-cart'>"+ res +"</span></span>";
                        $('#cart-button').before(icon);
//                        console.log(123);
                        $('#cart-img').addClass( "wibro" );
                        setTimeout(deleteClass,500);
                    }

//                    $('#cart-img').addClass( "wibro" );
//                    setTimeout('deleteClass',2000);
                },
                error: function(){

                }
            });
        });

        function deleteClass(){
            $('#cart-img').removeClass( "wibro" );
        }

        $('.tab-title').on('click', function(){
            $('.tab-title').removeClass('activate');
            $(this).addClass('activate');
            var id = $(this).data('id').valueOf();
            if (id == 'reviews') {
                $('#product-descripton').css('display','none');
                $('#reviews').css('display','block');
            } else {
                $('#product-descripton').css('display','block');
                $('#reviews').css('display','none');
            }
        });

        $('#minus').on('click', function(){
            var count = $('#count').val();
            if (count == 1) {
                return false;
            } else {
                $('#count').val(count-1);
                $('#minus').css({'background':0,'color':'white'});
            }
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
            gallery: {
                enabled: true
            },
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
        $('[data-id="cart"]').attr('href','/cart');
    })
</script>