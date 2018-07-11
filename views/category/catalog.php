<?php
/* @var $this yii\web\View */
/* @var $category \app\modules\dashboard\models\Category */
/* @var $allProduct \app\modules\dashboard\models\Product */
/* @var $allCheckboxes \app\modules\dashboard\models\Checkbox */
/* @var $checked \app\modules\dashboard\models\Checkbox */

use app\modules\dashboard\models\ProductImg;
use app\modules\dashboard\models\Checkbox;
use yii\helpers\Html;

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
                        <?php echo ProductImg::getImgByProductId($product->id)?>
                        <div class="caption cart-product-title">
                            <h3><?php echo $product->name?></h3>
                            <p><?php echo $product->small_text; ?></p>
                            <p><a href="#" class="btn did btn-outline">Просмотр</a> <a href="#" class="btn did btn-outline">В корзину</a></p>
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
        $('.checked').on('click', function(){
//        $(this).attr('checked', true);
            var id = $(this).val();
            var alias = $('#cat_alias').val();
//        console.log($('meta[name="csrf-token"]').attr("content"));
            $.ajax({
                url: 'sort-category',
                data: {_csrf: yii.getCsrfToken(),id: id,alias: alias},
                type: 'POST',
                success: function(res) {
                    console.log(res);
                    if (res) {
                        $('#content').html(res);
                        return false;
//                    $('#catalog').fadeOut();
                    }
                },
                error: function() {
                    console.log('error');
                }
            });
//       console.log(id);
        });

        $('[data-id="home"]').attr('href','/');
        $('[data-id="home"]').parent('li').removeClass('active');
        $('[data-id="catalog"]').attr('href','/#catalog');
        $('[data-id="catalog"]').parent('li').addClass('active');

        $('[data-id="service"]').attr('href','/#service');
        $('[data-id="portfolio"]').attr('href','/#portfolio');
        $('[data-id="clients"]').attr('href','/#clients');
        $('[data-id="contact"]').attr('href','/#contact');


//        console.log();
    })
</script>