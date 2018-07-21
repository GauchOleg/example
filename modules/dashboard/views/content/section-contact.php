<?php
/* @var $this yii\web\View */
/* @var $metaData \app\modules\dashboard\models\MetaData @type array */

use yii\helpers\Html;
?>

<div class="portlet green-sharp box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Секция Контакты
        </div>
    </div>
    <div class="portlet-body row" style="">
        <div class="col-md-4">
            <div class="form-group">
                <label>Заголовок</label>
                <?php echo Html::input('text', $metaData['contact_title']['meta_key'] , (!empty($metaData['contact_title']['meta_value']) ? $metaData['contact_title']['meta_value'] : ''), ['class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-md-4">
            <label>Адрес</label>
            <?php echo Html::textarea(
                $metaData['contact_address']['meta_key'],
                $metaData['contact_address']['meta_value'],
                ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
            ?>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Телефон</label>
                <?php echo Html::input('text', $metaData['contact_phone']['meta_key'] , (!empty($metaData['contact_phone']['meta_value']) ? $metaData['contact_phone']['meta_value'] : ''), ['class' => 'form-control']); ?>
            </div>
        </div>
    </div>
</div>
