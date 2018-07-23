<?php
/* @var $producers \app\modules\dashboard\models\Producer @type array */

?>

<div class="section third-section">
    <div class="container centered">
        <div class="sub-section">
            <div class="title clearfix">
                <div class="pull-left">
                    <h3>Произодители</h3>
                </div>
                <ul class="client-nav pull-right">
                    <li id="client-prev"></li>
                    <li id="client-next"></li>
                </ul>
            </div>
            <ul class="row client-slider" id="clint-slider">
                <?php if (!empty($producers)) :?>
                    <?php foreach ($producers as $producer) :?>
                        <li>
                            <a href="<?php echo \yii\helpers\Url::to(['/producer/' . $producer['id']])?>">
                                <img src="<?php echo $producer['image']?>" alt="client logo 1" style="height: 115px">
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>