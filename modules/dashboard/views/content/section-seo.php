<?php
/* @var $this yii\web\View */
/* @var $metaData \app\modules\dashboard\models\MetaData @type array */

use yii\helpers\Html;
?>

<div class="portlet green-sharp box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>SEO главной страници
        </div>
    </div>
    <div class="portlet-body row" style="">
        <div class="col-md-4">
            <div class="form-group">
                <label>Тайтл</label>
                <?php echo Html::input('text', $metaData['seo_title']['meta_key'] , (!empty($metaData['seo_title']['meta_value']) ? $metaData['seo_title']['meta_value'] : ''), ['class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-md-4">
            <label>Ключевые слова</label>
            <?php echo Html::textarea(
                $metaData['seo_keywords']['meta_key'],
                $metaData['seo_keywords']['meta_value'],
                ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
            ?>
        </div>
        <div class="col-md-4">
            <label>Мета-описание</label>
            <?php echo Html::textarea(
                $metaData['seo_description']['meta_key'],
                $metaData['seo_description']['meta_value'],
                ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
            ?>
        </div>
    </div>
</div>
