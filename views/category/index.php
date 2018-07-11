<?php
/* @var $this yii\web\View */
/* @var $category \app\modules\dashboard\models\Category */
/* @var $allProduct \app\modules\dashboard\models\Product */
/* @var $allCheckboxes \app\modules\dashboard\models\Checkbox */
/* @var $checked \app\modules\dashboard\models\Checkbox */
?>
<div id="catalog-product">
    <div class="container" id="catalog">
        <?php echo $this->render('catalog',[
            'category'      => $category,
            'allCheckboxes' => $allCheckboxes,
            'checked'       => $checked,
            'allProduct'    => $allProduct,
            'allCategory'   => $allCategory,
        ]);?>
    </div>
</div>
