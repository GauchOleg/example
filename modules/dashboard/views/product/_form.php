<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $checkboxesList \app\modules\dashboard\models\Checkbox */
/* @var $categoryList \app\modules\dashboard\models\Product */

$this->registerJsFile('/backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js');
$this->registerCssFile('/backend/css/custom.css');
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryList,[
        'prompt' => '-- Не выбрано --',
        'selected' => ($model->category_id) ? $model->category_id : '',
        'id' => 'change-category'
//        'disabled' => ($model->isNewRecord) ? false : true
    ]) ?>

    <div class="row">
        <div class="col-md-12">
            <div id="all-check">
                <?php if (!$model->isNewRecord): ?>
                    <?php foreach ($checkboxesList as $item): ?>
                        <label><input type='checkBox' name='Product[checkboxes][<?php echo $item['id']?>]' <?php echo ($item['active'] == 1) ? 'checked' : '' ?> value='<?php echo $item['id']?>'><?php echo $item['name']?></label>
                    <?php endforeach; ?>
                <?php else: ?>
                <p>Для отображения меток (чекбоксов) выберите категорию</p>
                <?php endif; ?>
            </div>
        </div>
    </div><br>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-12">
            <span class="btn did btn-outline" id="add-new"><i class="fa fa-camera-retro"></i></span>
        </div>
    </div><br>
    <div class="row">
        <div id="photo">
            <div class="last"></div>
            <?php if (isset($imgs) && !empty($imgs)): ?>
                <?php foreach ($imgs as $img): ?>
                    <div class="col-md-3" data-col="<?=$img->sort_id?>">
                        <div class="new" data-id="<?=$img->sort_id?>" class="product-gallery">
                            <div class="form-group">
                                <div class="portlet light bordered">
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                <a href="javascript:;" class="thumbnail">
                                                    <img class="preload-img-<?=$img->sort_id?>" src="<?= ($img->alias) ? $img->alias : 'http://www.placehold.it/320x200/EFEFEF/AAAAAA&amp;text=no+image'?>" alt="Новое фото" style="display: block; max-height: 200px;"> </a>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="file" style="display: none;" id="file<?=$img->sort_id?>" name="ProductImg[<?=$img->sort_id?>]" />
                                    <span class="btn did btn-outline file-btn" data-num="<?=$img->sort_id?>" id="load-img<?=$img->sort_id?>">Загрузить</span>
                                    <span class="btn red btn-outline file-del-btn" data-model="<?=$model->id?>" data-del="<?=$img->sort_id?>">Удалить</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="last"></div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?= $form->field($model, 'small_text')->textarea(['rows' => 3]) ?>

    <?php
    echo $form->field($model, 'text')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'standard', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]);
    ?>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keywords')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'seo_description')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'new')->checkbox() ?>

    <?= $form->field($model, 'sale')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(($model->isNewRecord) ? 'Сохранить' : 'Обновить', ['class' => 'btn did btn-outline']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    $(document).ready(function () {

        $('#add-new').on('click', function(){
            var dataId = $(document).find('.new').last().data('id');
            console.log(dataId);
            $.ajax({
                url: '/dashboard/product/add-field',
                data: {_csrf: yii.getCsrfToken(), num: dataId},
                type: 'POST',
                success: function (res) {
                    if (res) {
//                        var id = $(document).find('.new').data('id');
                        $(document).find('.last').last().after('<div class="last"></div>').html(res);
                    }
                },
                error: function () {
                    console.log('global error');
                }
            });
        });

        $("#photo").on('click', '.file-btn', function(){
            var id = $(this).data('num');
            var file = $(document).find('#file' + id).trigger('click');
                file.on('change', function (element) {
                   console.log(file);
                   var input = file[0];
                    if (input.files && input.files[0]) {
                        if (input.files[0].type.match('image.*')) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                $('.preload-img-' + id).attr('src', e.target.result);
                                // $.test.attr('src', e.target.result);
                            }
                            reader.readAsDataURL(input.files[0]);
                        } else {
                            console.log('ошибка, не изображение');
                        }
                    } else {
                        console.log('хьюстон у нас проблема');
                    }
                });
        });

        $("#photo").on('click', '.file-del-btn', function(){
            var id = $(this).data('del');
            var model = $(this).data('model');
            $.ajax({
                url: '/dashboard/product/delete-img',
                data: {_csrf: yii.getCsrfToken(), id: id, modelId: model},
                type: 'json',
                success: function (res) {
                },
                error: function () {
                    console.log('global error');
                }
            });
            var el = $("[data-col="+ id +"]").remove();
        });

        $("#change-category").on('change', function(element){
            var categoryId = $(this).val();
            $.ajax({
                url: '/dashboard/product-data/get-checkboxes',
                data: {_csrf: yii.getCsrfToken(), catId: categoryId},
                type: 'POST',
                success: function(res){
                    var checkBox = '<p>Добавить метки (чекбоксы) к товару</p><div class="check-menu">';
                    if (res) {
                        var ob = JSON.parse(res);
                        $.each(ob, function(index, value) {
                            checkBox += "<label><input type='checkBox' name='Product[checkboxes]["+ index +"]'  value='"+ index +"'>"+ value +"</label>"
                        });
                        $('#all-check').html(checkBox);
                    }
                    $('#all-check').css('display','');
                    $('#all-check').html(checkBox);
                },
                error: function(){
                    console.log('_form.php have some error or productDataController');
                }
            });
        });

    });
</script>