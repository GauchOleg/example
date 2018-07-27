<?php
/* @var $user \app\modules\user\models\User */
/* @var $this \yii\web\View */
/* @var $countOrders @type integer @method \app\modules\dashboard\models\Cart::getTotalOrdersByPhone() */
/* @var $meta \app\modules\user\models\UserMeta */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Мои настройки';
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
                url: '/client/settings/delete-img',
                data: {userId: id, _csrf: yii.getCsrfToken()},
                type: 'POST',
                success: function(res){
                    if(res) {
//                    console.log(res);
//                    return false;
                        $(\"#avatar\").attr('src', 'http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp?text=no+image');
                        $(\"#avatar-first\").attr('src', 'http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp?text=no+image');
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

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>Сохранено!</h4>
        <i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-error alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>Ошибка!</h4>
        <i class="icon fa fa-warning"></i> <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <!-- profile start -->
        <div class="portlet light profile-sidebar-portlet bordered">
            <div class="profile-userpic">
                <img id='avatar-first'src="<?php echo !empty($meta['image']['meta_value']) ? $meta['image']['meta_value'] : 'http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=no+image'?>" class="img-responsive" alt=""> </div>
            <div class="profile-usertitle">
                <div class="profile-usertitle-name"> username : <?php echo $user->username?></div>
            </div>
            <div class="profile-usermenu">
                <ul class="nav">
                    <li>
                        <i class="icon-info"></i> Всего заказов: <?php echo $countOrders;?>
                    </li>
                </ul>
            </div>
        </div>
        <!-- profile end -->
    </div>
    <div class="col-md-8">

        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase">Мои данные</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab" aria-expanded="false">Персональная информация</a>
                                </li>
                                <li class="">
                                    <a href="#tab_1_2" data-toggle="tab" aria-expanded="false">Изменить аватар</a>
                                </li>
                                <li class="">
                                    <a href="#tab_1_3" data-toggle="tab" aria-expanded="true">Изменить пароль</a>
                                </li>
                                <li class="">
                                    <a href="#tab_1_4" data-toggle="tab" aria-expanded="false">Россылка</a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <!-- PERSONAL INFO TAB -->
                                <div class="tab-pane active" id="tab_1_1">
                                    <?php $form = ActiveForm::begin([
                                        'options' => [
                                            'enctype' => 'multipart/form-data',
                                            'method' => 'POST',
                                        ],
                                        'action' => '/client/settings/update-profile',
                                    ])?>
                                        <div class="form-group">
                                            <label class="control-label">Имя</label>
                                            <?php echo Html::input('text','first_name',isset($meta['first_name']['meta_value']) ? $meta['first_name']['meta_value'] : '',['placeholder' => 'Иванов', 'class' => 'form-control'])?>
<!--                                            <input type="text" placeholder="Иванов" class="form-control">-->
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Фамилия</label>
                                            <?php echo Html::input('text','last_name',isset($meta['last_name']['meta_value']) ? $meta['last_name']['meta_value'] : '',['placeholder' => 'Иван', 'class' => 'form-control'])?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Номер телефона</label>
                                            <?php echo Html::input('text','add_phone',isset($meta['add_phone']['meta_value']) ? $meta['add_phone']['meta_value'] : '',['placeholder' => '+38(050)123-45-67', 'class' => 'form-control', 'id' => 'phone'])?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">О себе</label>
                                            <?php echo Html::textarea('about',isset($meta['about']['meta_value']) ? $meta['about']['meta_value'] : '',['placeholder' => 'Постоянный клиент', 'class' => 'form-control', 'rows' => 3])?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Мой сайт</label>
                                            <?php echo Html::input('text','site',isset($meta['site']['meta_value']) ? $meta['site']['meta_value'] : '',['placeholder' => 'http://www.mywebsite.com', 'class' => 'form-control'])?>
                                        </div>
                                        <div class="margiv-top-10">
                                            <?php echo Html::input('hidden','userId',Yii::$app->user->identity->getId())?>
                                            <?php echo Html::button('Обновить',['class' => 'btn did btn-outline','type' => 'submit'])?>
                                        </div>
                                    <?php ActiveForm::end();?>
<!--                                    </form>-->
                                </div>
                                <!-- END PERSONAL INFO TAB -->
                                <!-- CHANGE AVATAR TAB -->
                                <div class="tab-pane" id="tab_1_2">
                                    <div class="row">
                                        <div id="photo">
                                            <div class="col-md-3" data-col="">
                                                <?php $form = ActiveForm::begin([
                                                    'options' => [
                                                        'enctype' => 'multipart/form-data',
                                                        'method' => 'POST',
                                                    ],
                                                    'action' => '/client/settings/update-image',
                                                ])?>
                                                <!-- block img -->
                                                <div class="form-group">
                                                    <div class="form-group <?php echo ($model->hasErrors('image')) ? 'has-error' : '' ?>" style="margin: 0 2px">
                                                        <div class="fileinput fileinput-<?= isset($meta['image']['meta_value']) ? 'exists' : 'new' ?>" data-provides="fileinput" data-ration="200:200">
                                                            <div class="fileinput-preview thumbnail exerciseImgPreview" data-trigger="fileinput">
                                                                <img id="avatar" src="<?= !empty($meta['image']['meta_value']) ? $meta['image']['meta_value'] : 'http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=no+image' ?>"> </div>
                                                            <div>
                                                            <span class="btn green btn-outline btn-file"> <span class="fileinput-new"> <?= Yii::t('app', 'Выбрать') ?> </span> <span class="fileinput-exists"> <?= Yii::t('app', 'Изменить') ?> </span>
                                                                <?= Html::activeFileInput($model, 'image', ['class' => 'js-file-input']) ?>
                                                                <?= Html::hiddenInput('img[x]', null, ['class' => 'crop_x']) ?>
                                                                <?= Html::hiddenInput('img[y]', null, ['class' => 'crop_y']) ?>
                                                                <?= Html::hiddenInput('img[w]', null, ['class' => 'crop_w']) ?>
                                                                <?= Html::hiddenInput('img[h]', null, ['class' => 'crop_h']) ?>
                                                            </span>
                                                                <!--                    --><?php //echo Html::button('Удалить', ['class' => 'btn red btn-outline','id' => 'delImg', 'data-id' => $model->id]) ?>
                                                                <span class="btn red btn-outline del-img" data-id="<?=Yii::$app->user->identity->getId()?>" id="delImg"><?= Yii::t('app', 'Удалить') ?> </span>
                                                                <?php if (isset($mainOriginalImage) && !empty($mainOriginalImage)): ?>
                                                                    <?= Html::a('<i class="fa fa-eye"></i> ' . Yii::t('app', 'Original'), $mainOriginalImage, ['target' => '_blank', 'class' => 'btn btn-outline blue']) ?>
                                                                <?php endif; ?> </div> <?php if ($model->hasErrors('image')): ?> <div class="help-block"><?php echo array_shift($model->getErrors('image')) ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="margiv-top-10">
                                                    <?php echo Html::input('hidden','userId',Yii::$app->user->identity->getId())?>
                                                    <?php echo Html::button('Обновить',['class' => 'btn did btn-outline','type' => 'submit'])?>
                                                </div>
                                                <!-- end block img -->
                                                <?php ActiveForm::end();?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END CHANGE AVATAR TAB -->

                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane" id="tab_1_3">
                                    <?php $form = ActiveForm::begin([
                                        'options' => [
                                            'enctype' => 'multipart/form-data',
                                            'method' => 'POST',
                                        ],
                                        'action' => '/client/settings/update-password',
                                        'enableClientValidation' => true
                                    ])?>
                                        <div class="form-group">
                                            <label class="control-label">Текущий пароль</label>
                                            <?php echo $form->field($user,'password')->passwordInput(['value'=>''])->label(false)?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Новый пароль</label>
                                            <?php echo $form->field($user,'new_password')->passwordInput()->label(false)?>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Еще раз новый пароль</label>
                                            <?php echo $form->field($user,'password_repeat')->passwordInput()->label(false)?>
                                        </div>
                                        <?php echo Html::input('hidden','User[id]',Yii::$app->user->identity->getId())?>
                                        <div class="margiv-top-10">
                                            <?= Html::submitButton('Обновить', ['class' => 'btn did btn-outline']) ?>
                                        </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                                <!-- END CHANGE PASSWORD TAB -->

                                <!-- PRIVACY SETTINGS TAB -->
                                <div class="tab-pane" id="tab_1_4">
                                    <?php $form = ActiveForm::begin([
                                        'options' => [
                                            'enctype' => 'multipart/form-data',
                                            'method' => 'POST',
                                        ],
                                        'action' => '/client/settings/update-profile',
                                    ])?>
                                        <table class="table table-light table-hover">
                                            <tbody><tr>
                                                <td> Подписаться на акции и распродажи </td>
                                                <td>
                                                    <div class="mt-radio-inline">
                                                        <?php echo Html::radioList('spam',isset($meta['spam']['meta_value']) ? $meta['spam']['meta_value'] : 2,[1 => 'Да', 2 => 'Нет'],['class' => 'mt-radio'])?>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                        <!--end profile-settings-->
                                        <div class="margin-top-10">
                                            <?php echo Html::input('hidden','userId',Yii::$app->user->identity->getId())?>
                                            <?php echo Html::button('Обновить',['class' => 'btn did btn-outline','type' => 'submit'])?>
                                        </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                                <!-- END PRIVACY SETTINGS TAB -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PROFILE CONTENT -->
    </div>
</div>
<!--<div class="row">-->
<!--    <div class="col-md-12">-->
<!--        <span class="btn did btn-outline file-btn" data-num="" id="load-img">Загрузить</span>-->
<!--    </div>-->
<!--</div>-->

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

<script>
    $(document).ready(function () {
        $("#phone").mask("+38(099) 999-99-99");
    });
</script>