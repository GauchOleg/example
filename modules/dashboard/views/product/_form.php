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
            <span class="btn did btn-outline file-btn" id="add-new"><i class="fa fa-camera-retro"></i></span>
        </div>
    </div><br>
    <div class="row" id="photo">
<!--        --><?php
//            echo $this->render('_add_file')
//        ?>

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
    $('#add-new').on('click', function(){
//        var result = $(document).find('.product-gallery');
        console.log('click');
            $.ajax({
                url: '/dashboard/product/add-field',
                data: {_csrf: yii.getCsrfToken()},
                type: 'POST',
                success: function (res) {
                    if (res) {
                         console.log(res);
                    }
                },
                error: function () {
                    console.log('global error');
                }
            });
    })
</script>