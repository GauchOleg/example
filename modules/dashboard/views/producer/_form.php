<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Producer */
/* @var $form yii\widgets\ActiveForm */
/* @var $statusList \app\modules\dashboard\models\Producer @type array */
?>

<div class="producer-form">

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div id="photo">
            <div class="col-md-3" data-col="">
                <div class="new" data-id="" class="product-gallery">
                    <div class="form-group">
                        <div class="portlet light bordered">
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <a href="javascript:;" class="thumbnail">
                                            <img class="preload-img" src="<?= ($model->image) ? $model->image : 'http://www.placehold.it/320x200/EFEFEF/AAAAAA&amp;text=no+image'?>" alt="Новое фото" style="display: block; max-height: 200px;">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <input type="file" style="display: none;" id="file" name="Producer[img]" data-id="<?php echo $model->isNewRecord ? false : $model->id ?>" />
                            <span class="btn did btn-outline file-btn" data-num="" id="load-img">Загрузить</span>
                            <span class="btn red btn-outline file-del-btn" data-model="" data-del="">Удалить</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--    --><?php //echo $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="row">
        <div class="col-md-2">
    <?= $form->field($model, 'active')->dropDownList($statusList) ?>
        </div>
    </div>

    <?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seo_keywords')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'seo_description')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton(($model->isNewRecord) ? 'Сохранить' : 'Обновить', ['class' => 'btn did btn-outline']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).ready(function () {

        $(".file-btn").on('click', function() {
            var file = $(document).find('#file').trigger('click');
            file.on('change', function (element) {
//                console.log(file);
                var input = file[0];
                if (input.files && input.files[0]) {
                    if (input.files[0].type.match('image.*')) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('.preload-img').attr('src', e.target.result);
//                            $('#file').attr('value',input.files[0]);
                            // $.test.attr('src', e.target.result);
                        }
//                        console.log(reader);
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        console.log('ошибка, не изображение');
                    }
                } else {
                    console.log('хьюстон у нас проблема');
                }
            });
        });

        $(".file-del-btn").on('click', function() {
            var id = $('#file').data('id');
            if (!id) {
                $(".preload-img").attr('src','http://www.placehold.it/320x200/EFEFEF/AAAAAA&amp;text=no+image');
            } else {
                $.ajax({
                    url: 'priver/delete-image',
                    data: {_csrf: yii.getCsrfToken(), id: id},
                    type: 'json',
                    success: function (res) {
                        console.log(res);
                    },
                    error: function () {
                        console.log('global error');
                    }
                });
            }
//            console.log(id);
//            return false;


//            var el = $("[data-col="+ id +"]").remove();
        });

    });
</script>