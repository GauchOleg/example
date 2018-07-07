<?php

/* @var $allCategory \app\modules\dashboard\models\Category */
use yii\helpers\Url;

$countCategory = count($allCategory);
?>
<div class="section primary-section catalog-section" id="catalog">
    <div class="container">
        <?php $i = 4; $j = 1; foreach ($allCategory as $category): ?>
            <?= ($i % 4 == 0) ? '<div class="row">' : ''?>
            <div class="span3 pb-3 category-tab category-tab-phone">
                <div class="animated fadeInDown image-category">
                    <a href="<?= Url::to(['/category', 'id' => $category['alias']])?>">
                        <img src="<?= $category['image']; ?>" alt="team 1" class="img-circle">
                    </a>
                    <h4 class="center pt-category-title"><?= $category['name']?></h4>
                </div>
            </div>
            <?= ($j % 4 == 0 || end($allCategory)['id'] == current($category)) ? '</div>' : ''?>
            <?php $i++; $j++; endforeach; ?>
    </div>
</div>
