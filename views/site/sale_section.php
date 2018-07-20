<?php
/* @var $saleProduct \app\modules\dashboard\controllers\ProductController @type array */
/* @var $imgs \app\modules\dashboard\models\ProductImg @type array */


use yii\helpers\Html;
use app\modules\dashboard\models\ProductImg;
use app\modules\dashboard\models\Product;

?>

<!-- Portfolio section start -->
<div class="section secondary-section " id="portfolio">
    <div class="triangle"></div>
    <div class="container">
        <div class=" title">
            <h2>Спец предложение</h2>
            <p>Регулярное проведений акций, также пополнение новыми товарами в магазине тренажеров ЕВРОСПОРТ</p>
        </div>
        <ul class="nav nav-pills">
            <li class="filter" data-filter="all">
                <a href="#noAction">Все</a>
            </li>
            <li class="filter" data-filter="web">
                <a href="#noAction">Новинка</a>
            </li>
            <li class="filter" data-filter="photo">
                <a href="#noAction">Акция</a>
            </li>
            <!--            <li class="filter" data-filter="identity">-->
            <!--                <a href="#noAction"></a>-->
            <!--            </li>-->
        </ul>
        <!-- Start details for portfolio project 1 -->

        <div id="single-project">
            <?php if (isset($saleProduct) && !empty($saleProduct)) :?>
                <?php foreach ($saleProduct as $item): ?>
                <div id="slidingDiv<?php echo $item['id']?>" class="toggleDiv row-fluid single-project">
                    <div class="span6">
                        <img src="<?php echo (isset($imgs[$item['id']])) ? $imgs[$item['id']]['alias'] : ProductImg::DEFAULT_IMG?>" alt="<?php echo $item['name']?>" />
                    </div>
                    <div class="span6">
                        <div class="project-description">
                            <div class="project-title clearfix">
                                <h3><?php echo $item['name']?></h3>
                                <span class="show_hide close">
                                    <i class="icon-cancel"></i>
                                </span>
                            </div>
                            <div class="project-info">
                                <div>
                                    <span>Категория </span> <?php echo Product::getCategoryNameByProductId($item['category_id'])?>
                                </div>
                                <div>
                                    <span>Цена </span> <?php echo (!empty($item['price']) ? $item['price'] . ' грн.' : ' нет ')?>
                                </div>
                                <div>
                                    <span>Код </span> <?php echo $item['code']?>
                                </div>
                                <div>
                                    <?php echo Html::a('Перейти к товару',['product/view','alias' => $item['alias']],['class' => 'cart-link'])?>
                                </div>
                            </div>
                            <p><?php echo $item['small_text']?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (isset($saleProduct) && !empty($saleProduct)) :?>
                <ul id="portfolio-grid" class="thumbnails row">
                    <?php foreach ($saleProduct as $item): ?>
                        <li class="span4 mix <?php echo ($item['sale'] == 1) ? 'photo' : 'web'; ?>">
                            <div class="thumbnail">
                                <span class="sale-image">
                                    <img src="<?php echo (isset($imgs[$item['id']])) ? $imgs[$item['id']]['alias'] : ProductImg::DEFAULT_IMG?>" alt="<?php echo $item['name']?> " style="height: 236px">
                                </span>
                                <a href="#single-project" class="more show_hide" rel="#slidingDiv<?php echo $item['id']?>">
                                    <i class="icon-plus"></i>
                                </a>
                                <h3><?php echo Html::a(mb_strimwidth($item['name'],0,30),['product/view','alias' => $item['alias']],['class' => 'sale-section-link'])?></h3>
                                <p><?php echo Html::a($item['price'] . ' грн.',['product/view','alias' => $item['alias']],['class' => 'sale-section-link-price'])?></p>
                                <div class="mask"></div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <!-- End details for portfolio project 9 -->
        </div>
    </div>
</div>
<!-- Portfolio section end -->