<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use app\modules\dashboard\assets\BackendGlobalAsset;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
// start crop js
$this->registerCssFile('/backend/css/image-uploader.css');

$this->registerCssFile('/backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$this->registerCssFile('/backend/global/plugins/jcrop/css/jquery.Jcrop.min.css');

$this->registerCssFile('/backend/global/plugins/dropzone/dropzone.min.css');
$this->registerCssFile('/backend/global/plugins/dropzone/basic.min.css');

$this->registerJsFile('/backend/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js');
$this->registerJsFile('/backend/global/plugins/jcrop/js/jquery.color.js');
$this->registerJsFile('/backend/global/plugins/jcrop/js/jquery.Jcrop.min.js');

$this->registerJsFile('/backend/global/plugins/dropzone/dropzone.min.js');

$this->registerJs("
    $(document).on('change.bs.fileinput', function (e) {
    
        if (e.namespace != 'bs.fileinput') {
            return;
        }
        var target = e.target;
        var imgEl = $(target).find('img');
        var src = imgEl[0].src;
        var ration = $(target).data('ration');

        if (typeof ration != 'undefined') {
            ration = ration.split(':');
            if (ration.length > 1) {
                ration = ration[0] / ration[1];
            }

        } else {
            ration = 1;
        }

        $('#js-image-crop').prop('src', src);
        $('#static').modal('show');

        if (typeof jcrop_api != 'undefined') {
            jcrop_api.destroy();
        }

        $('#js-image-crop').Jcrop({
            bgFade: true,
            bgOpacity: .5,
            setSelect: [60, 70, 540, 330],
            boxWidth: 870,
            boxHeight: 600,
            aspectRatio: ration,
            onSelect: function (e) {
                $(target).find('input.crop_x').val(e.x);
                $(target).find('input.crop_y').val(e.y);
                $(target).find('input.crop_w').val(e.w);
                $(target).find('input.crop_h').val(e.h);
            }
        }, function () {
            jcrop_api = this;
        });

    });
    
    $(document).ready(function(){
        $('#delImg').on('click', function(element){
            var id = $(this).attr(\"data-id\");
            $.ajax({
                url: '/dashboard/category/delete-img',
                data: {img: id},
                type: 'GET',
                success: function(res){
                    if(res) {
                        $(\"#categoryImg\").attr('src', 'http://www.placehold.it/100x100/EFEFEF/AAAAAA&amp?text=no+image');
                    } else {
                        console.log('Что-то не то ...');
                    }
                },
                error: function(){
                    console.log('Глобальные траблы.. ');
                }
            });
        });
    });
    
   
        ");
?>
<div class="category-form">

    <?php $form = ActiveForm::begin(
        ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <!-- block img -->
    <div class="form-group">
        <div class="form-group <?= ($model->hasErrors('image')) ? 'has-error' : '' ?>" style="margin: 0 2px">
            <div class="fileinput fileinput-<?= !is_null($model->imageFile) ? 'exists' : 'new' ?>" data-provides="fileinput" data-ration="200:200">
                <div class="fileinput-preview thumbnail exerciseImgPreview" data-trigger="fileinput">
                    <img id="categoryImg" src="<?= !empty($model->image) ? $model->image : 'http://www.placehold.it/100x100/EFEFEF/AAAAAA&amp;text=no+image' ?>"> </div>
                <div>
                                                            <span class="btn red btn-outline btn-file"> <span class="fileinput-new"> <?= Yii::t('app', 'Выбрать') ?> </span> <span class="fileinput-exists"> <?= Yii::t('app', 'Change') ?> </span>
                                                                <?= Html::activeFileInput($model, 'imageFile', ['class' => 'js-file-input']) ?>
                                                                <?= Html::hiddenInput('img[x]', null, ['class' => 'crop_x']) ?>
                                                                <?= Html::hiddenInput('img[y]', null, ['class' => 'crop_y']) ?>
                                                                <?= Html::hiddenInput('img[w]', null, ['class' => 'crop_w']) ?>
                                                                <?= Html::hiddenInput('img[h]', null, ['class' => 'crop_h']) ?>
                                                            </span>
<!--                    --><?php //echo Html::button('Удалить', ['class' => 'btn red btn-outline','id' => 'delImg', 'data-id' => $model->id]) ?>
                    <span class="btn red btn-outline del-img" data-id="<?=$model->id?>" id="delImg"><?= Yii::t('app', 'Удалить') ?> </span>
                    <?php if (isset($mainOriginalImage) && !empty($mainOriginalImage)): ?>
                        <?= Html::a('<i class="fa fa-eye"></i> ' . Yii::t('app', 'Original'), $mainOriginalImage, ['target' => '_blank', 'class' => 'btn btn-outline blue']) ?>
                    <?php endif; ?> </div> <?php if ($model->hasErrors('image')): ?> <div class="help-block"><?= array_shift($model->getErrors('image')) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- end block img -->

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

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn did btn-outline']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div id="static" class="modal fade bs-modal-lg" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title"><?= Yii::t('app', 'Image Cropping') ?></h4> </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 responsive-1024">
                        <img src="" id="js-image-crop" alt="Jcrop Example" style="display: block; visibility: visible; width: 100%; height: auto;">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn green"><?= Yii::t('app', 'Crop') ?></button>
            </div>
        </div>
    </div>
</div>

