<?php
/* @var $this yii\web\View */
/* @var $category \app\modules\dashboard\models\Category */
/* @var $allProduct \app\modules\dashboard\models\Product */
/* @var $allCheckboxes \app\modules\dashboard\models\Checkbox */
/* @var $checked \app\modules\dashboard\models\Checkbox */

use app\modules\dashboard\models\ProductImg;
?>
<div class="container" id="catalog">
    <input id="cat_alias" type="hidden" name="alias" value="<?php echo $category->alias; ?>">
    <div class="row">
        <div class="col-md-12 center category-title">
            <h4><?php echo $category->name?></h4>
        </div>
    </div>
    <div class="row">
        <div class="span3">
            <?php if (isset($allCheckboxes) && !empty($allCheckboxes)) :?>
                <ul class="checkbox-menu">
                    <?php foreach ($allCheckboxes as $checkbox): ?>
                        <li>
                            <label class="checkbox">
                                <span class="checkbox-name"><input class="checked" type="checkbox" value="<?php echo $checkbox->id?>" <?php echo in_array($checkbox->id,$checked) ? 'checked' : '' ?> > <?php echo $checkbox->name; ?></span>
                            </label>
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

        <?php endif;?>
    </div>
</div>

<script>
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
                var tag = '';
                if (res) {
                    $('#catalog').html(res);
                }
            },
            error: function() {
                console.log('error');
            }
        });
//       console.log(id);
    });
</script>
