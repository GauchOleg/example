<?php
/* @var $allCategory \app\modules\dashboard\models\Category */
/* @var $allSliders \app\modules\dashboard\models\Slider @type array */
/* @var $metaData \app\modules\dashboard\models\MetaData @type array */
/* @var $saleProduct \app\modules\dashboard\controllers\ProductController @type array */
/* @var $imgs \app\modules\dashboard\models\ProductImg @type array */
/* @var $producers \app\modules\dashboard\models\Producer @type array */
/* @var $seo \app\modules\dashboard\models\MetaData @type array */

use yii\helpers\Url;

if (isset($seo) && !empty($seo)) {
    $this->title = $seo['seo_title'];

    $this->registerMetaTag([
        'name' => 'title',
        'content' => $seo['seo_title'],
    ]);
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $seo['seo_keywords'],
    ]);
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $seo['seo_description'],
    ]);
}
?>

<?php echo $this->render('slider_section',[
    'allSliders' => $allSliders
]);?>

<?php echo $this->render('catalog_section',compact('allCategory'));?>

<?php echo $this->render('service_section',[
    'metaData' => $metaData,
]);?>

<?php echo $this->render('sale_section',[
    'metaData' => $metaData,
    'saleProduct' => $saleProduct,
    'imgs' => $imgs,
]);?>

<?php echo $this->render('about_section',[
    'metaData' => $metaData,
]);?>

<?php echo $this->render('provider_section',[
    'metaData' => $metaData,
    'producers' => $producers,
]);?>

<?php echo $this->render('contact_section',[
    'metaData' => $metaData,
]); ?>

<script>
    $('[data-id="cart"]').attr('href','/cart');
</script>
