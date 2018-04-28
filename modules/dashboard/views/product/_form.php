<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Product */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('/backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js');
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryList,[
        'prompt' => '-- Не выбрано --',
//        'disabled' => ($model->isNewRecord) ? false : true
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

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
        </div>
    </div>

<!--    --><?//= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
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

<!--    --><?//= $form->field($model, 'create_at')->textInput() ?>

<!--    --><?//= $form->field($model, 'update_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn did btn-outline']) ?>
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

//        $('#photo').on('change', '.file-btn', function () {
//           console.log('adwawd');
//        });

        $("#photo").on('click', '.file-del-btn', function(){
            var id = $(this).data('del');
            var el = $("[data-col="+ id +"]").remove();
        });

    });
</script>