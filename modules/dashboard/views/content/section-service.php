<?php
/* @var $this yii\web\View */
/* @var $metaData \app\modules\dashboard\models\MetaData @type array */

use yii\helpers\Html;
?>

<div class="portlet green-sharp box">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>Секция сервис
        </div>
    </div>
    <div class="portlet-body row" style="">
        <div class="col-md-6">
            <div class="form-group">
                <label>Заголовок</label>
                <?php echo Html::input('text', $metaData['service_title']['meta_key'] , (!empty($metaData['service_title']['meta_value']) ? $metaData['service_title']['meta_value'] : ''), ['class' => 'form-control']); ?>
            </div>
        </div>
        <div class="col-md-6">
            <label>Описание</label>
            <?php echo Html::textarea(
                $metaData['service_description']['meta_key'],
                $metaData['service_description']['meta_value'],
                ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
            ?>
        </div>
    </div>
    <div class="portlet-body row" style="">
        <div class="col-md-4">
            <div class="form-group">

                <label>Первый блок заголовок</label>
                <?php echo Html::input('text', $metaData['service_first_item_title']['meta_key'] , (!empty($metaData['service_first_item_title']['meta_value']) ? $metaData['service_first_item_title']['meta_value'] : ''), ['class' => 'form-control']); ?>
                <br>
                <label>Первый блок описание</label>
                <?php echo Html::textarea(
                    $metaData['service_first_item_description']['meta_key'],
                    $metaData['service_first_item_description']['meta_value'],
                    ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">

                <label>Второй блок заголовок</label>
                <?php echo Html::input('text', $metaData['service_second_item_title']['meta_key'] , (!empty($metaData['service_second_item_title']['meta_value']) ? $metaData['service_second_item_title']['meta_value'] : ''), ['class' => 'form-control']); ?>
                <br>
                <label>Второй блок описание</label>
                <?php echo Html::textarea(
                    $metaData['service_second_item_description']['meta_key'],
                    $metaData['service_second_item_description']['meta_value'],
                    ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">

                <label>Третий блок заголовок</label>
                <?php echo Html::input('text', $metaData['service_third_item_title']['meta_key'] , (!empty($metaData['service_third_item_title']['meta_value']) ? $metaData['service_third_item_title']['meta_value'] : ''), ['class' => 'form-control']); ?>
                <br>
                <label>Третий блок описание</label>
                <?php echo Html::textarea(
                    $metaData['service_third_item_description']['meta_key'],
                    $metaData['service_third_item_description']['meta_value'],
                    ['class' => 'form-control', 'rows' => 2, 'cols' => 12]);
                ?>
            </div>
        </div>
    </div>
</div>
