<?php
/* @var $this yii\web\View */
/* @var $metaData \app\modules\dashboard\models\MetaData @type array */

use yii\helpers\Html;
?>

<div class="portlet green-sharp box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Секция О нас
        </div>
    </div>
    <div class="portlet-body row" style="">
        <div class="col-md-4">
            <div class="form-group">
                <label>Заголовок</label>
                <?php echo Html::input('text', $metaData['about_title']['meta_key'] , (!empty($metaData['about_title']['meta_value']) ? $metaData['about_title']['meta_value'] : ''), ['class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-md-4">
            <label>Первое описание</label>
            <?php echo Html::textarea(
                $metaData['about_first_description']['meta_key'],
                $metaData['about_first_description']['meta_value'],
                ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
            ?>
        </div>
        <div class="col-md-4">
            <label>Второе описание</label>
            <?php echo Html::textarea(
                $metaData['about_second_description']['meta_key'],
                $metaData['about_second_description']['meta_value'],
                ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
            ?>
        </div>
    </div>
</div>
