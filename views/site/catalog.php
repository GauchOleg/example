<?php

/* @var $allCategory \app\modules\dashboard\models\Category; */
/* @var $this yii\web\View */
use yii\helpers\Url;
?>

<div id="catalog" class="catalog pb-3">
<!--    <div class="primary-section">-->
        <div class="container">
            <?php $i = 4; $j = 1; foreach ($allCategory as $category): ?>

                <?= ($i % 4 == 0) ? '<div class="row">' : ''?>
                    <div class="span3 pb-3">
                        <div class="animated fadeInDown image-category">
                            <a href="<?= Url::to(['site/category','id' => $category->alias])?>">
                                <img src="<?= $category['image']; ?>" alt="team 1">
                            </a>
                            <h3><?= $category['name']?></h3>
                        </div>
                    </div>
                <?= ($j % 4 == 0 || end($allCategory)['id'] == current($category)) ? '</div>' : ''?>
            <?php $i++; $j++; endforeach; ?>


            <div class="row">
                <div class="about-text centered">
                    <h3>About Us</h3>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.</p>
                </div>
            </div>
        </div>
<!--    </div>-->
</div>