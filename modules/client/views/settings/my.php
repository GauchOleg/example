<?php
/* @var $user \app\modules\user\models\User */
/* @var $this \yii\web\View */
/* @var $countOrders @type integer @method \app\modules\dashboard\models\Cart::getTotalOrdersByPhone() */
/* @var $meta \app\modules\user\models\UserMeta */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Мои настройки'
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i>Сохранено!</h4>
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-error alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i>Ошибка!</h4>
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <!-- profile start -->
        <div class="portlet light profile-sidebar-portlet bordered">
            <div class="profile-userpic">
                <img src="/backend/layouts/layout/img/avatar3_small.jpg" class="img-responsive" alt=""> </div>
            <div class="profile-usertitle">
                <div class="profile-usertitle-name"> username : </div>
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
                                <li class="">
                                    <a href="#tab_1_1" data-toggle="tab" aria-expanded="false">Персональная информация</a>
                                </li>
                                <li class="">
                                    <a href="#tab_1_2" data-toggle="tab" aria-expanded="false">Изменить аватар</a>
                                </li>
                                <li class="active">
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
                                <div class="tab-pane" id="tab_1_1">
                                    <?php $form = ActiveForm::begin([
                                        'options' => [
                                            'id' => 'user-password',
                                            'enctype' => 'multipart/form-data',
                                            'method' => 'POST',
                                        ],
                                        'action' => '/client/settings/update-profile',
                                    ])?>
                                        <div class="form-group">
                                            <label class="control-label">Имя</label>
                                            <?php echo Html::input('text','username','',['placeholder' => 'Иванов', 'class' => 'form-control'])?>
<!--                                            <input type="text" placeholder="Иванов" class="form-control">-->
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Фамилия</label>
                                            <input type="text" placeholder="Иван" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Номер телефона</label>
                                            <input type="text" placeholder="+38 050-123-45-67" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">О себе</label>
                                            <textarea class="form-control" rows="3" placeholder="Постоянный клиент"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Мой сайт</label>
                                            <input type="text" placeholder="http://www.mywebsite.com" class="form-control">
                                        </div>
                                        <div class="margiv-top-10">
                                            <?php echo Html::input('hidden','User[id]',$user->id)?>
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
                                                <div class="new" data-id="" class="product-gallery">
                                                    <div class="form-group">
                                                        <div class="portlet light bordered">
                                                            <div class="portlet-body">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <img class="preload-img" src="<?php echo /*($model->image) ? $model->image :*/ 'http://www.placehold.it/180x200/EFEFEF/AAAAAA&amp;text=no+image'?>" alt="Новое фото" style="display: block; max-height: 200px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="file" style="display: none;" id="file" name="Slider[img]" data-id="<?php echo 1/*$model->isNewRecord ? false : $model->id */?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="btn did btn-outline file-btn" data-num="" id="load-img">Загрузить</span>
                                                <span class="btn red btn-outline file-del-btn" data-model="" data-del="">Удалить</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END CHANGE AVATAR TAB -->

                                <!-- CHANGE PASSWORD TAB -->
                                <div class="tab-pane active" id="tab_1_3">
                                    <?php $form = ActiveForm::begin([
                                        'options' => [
                                            'id' => 'user-password',
                                            'enctype' => 'multipart/form-data',
                                            'method' => 'POST',
                                        ],
                                        'action' => '/client/settings/update-password',
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
                                        <?php echo Html::input('hidden','User[id]',$user->id)?>
                                        <div class="margiv-top-10">
                                            <?= Html::submitButton('Обновить', ['class' => 'btn did btn-outline']) ?>
                                        </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                                <!-- END CHANGE PASSWORD TAB -->

                                <!-- PRIVACY SETTINGS TAB -->
                                <div class="tab-pane" id="tab_1_4">
<!--                                    <form action="#">-->
                                        <table class="table table-light table-hover">
                                            <tbody><tr>
                                                <td> Подписаться на акции и распродажи </td>
                                                <td>
                                                    <div class="mt-radio-inline">
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios1" value="option1"> Да
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio">
                                                            <input type="radio" name="optionsRadios1" value="option2" checked=""> Нет
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                        <!--end profile-settings-->
                                        <div class="margin-top-10">
                                            <?php echo Html::submitButton('Обновить',['class' => 'btn did btn-outline'])?>
                                        </div>
<!--                                    </form>-->
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