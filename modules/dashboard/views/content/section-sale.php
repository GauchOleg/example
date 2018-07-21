<?php
/* @var $this yii\web\View */
/* @var $metaData \app\modules\dashboard\models\MetaData @type array */

use yii\helpers\Html;
?>

<div class="portlet green-sharp box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Секция Акция
        </div>
    </div>
    <div class="portlet-body row" style="">
        <div class="col-md-6">
            <div class="form-group">
                <label>Заголовок</label>
                <?php echo Html::input('text', $metaData['sale_title']['meta_key'] , (!empty($metaData['sale_title']['meta_value']) ? $metaData['sale_title']['meta_value'] : ''), ['class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-md-6">
            <label>Описание</label>
            <?php echo Html::textarea(
                $metaData['sale_description']['meta_key'],
                $metaData['sale_description']['meta_value'],
                ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
            ?>
        </div>
    </div>
</div>
