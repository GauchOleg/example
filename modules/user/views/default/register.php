<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Регистрация';
?>

<div class="row">
    <div class="col-md-4">

    </div>
    <div class="col-md-4">
        <div class="logo">
            <a href="/">
                <p>EUROSPORT FITNESS SYSTEM</p>
            </a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p style="text-align: center; color: green">Регистрация нового пользователя</p>
            </div>
        </div>
        <div class="login-form">
            <?php $form = ActiveForm::begin([
//                'action' => '/user/default/check-user-data',
            ]) ?>

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
                    <h4>Ошибка!</h4>
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <?php echo $form->field($model,'phone')?>
            <?php echo $form->field($model,'email')?>
            <?php echo $form->field($model,'password')->passwordInput()?>

            <div class="row">
                <div class="col-md-12" style="text-align: center;">
                    <?php echo Html::submitButton('Регистрация',['class' => 'btn btn-outline did add-cart'])?>
                </div>
            </div>

            <?php ActiveForm::end() ?>
        </div>

    </div>
    <div class="col-md-4">

    </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="copyright logo"> 2018 EUROSPORT FITNESS SYSTEM </div>
    </div>
</div>

<script>
    $("#loginform-phone").mask("+38(099) 999-99-99");
</script>