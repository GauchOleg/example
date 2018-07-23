<?php
/* @var $model \app\modules\dashboard\models\Producer @type array */
/* @var $this yii\web\View */

use yii\helpers\Html;

if (isset($model) && !empty($model)) {
    $this->title = $model['name'];

    $this->registerMetaTag([
        'name' => 'title',
        'content' => $model['seo_title'],
    ]);
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $model['seo_keywords'],
    ]);
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $model['seo_description'],
    ]);
}
?>

<div class="section primary-section catalog-section" id="cart-view">
    <div class="container producer">
        <div class="row">
            <div class="span12">
                <h1 class="center"><?php echo $model['name']?></h1>
            </div>
        </div>
        <div class="row">
            <div class="span3">
                <?php echo Html::img($model['image'])?>
            </div>
            <div class="span9">
                <?php echo $model['description']?>
            </div>
        </div>
    </div>
</div>

<script>
    $('[data-id="home"]').attr('href','/');
    $('[data-id="home"]').parent('li').removeClass('active');
    $('[data-id="catalog"]').attr('href','/#catalog');

    $('[data-id="service"]').attr('href','/#service');
    $('[data-id="portfolio"]').attr('href','/#portfolio');
    $('[data-id="clients"]').attr('href','/#clients');
    $('[data-id="contact"]').attr('href','/#contact');
    $('[data-id="cart"]').attr('href','/cart');
</script>