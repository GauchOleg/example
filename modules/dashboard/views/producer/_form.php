<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Producer */
/* @var $form yii\widgets\ActiveForm */
/* @var $statusList \app\modules\dashboard\models\Producer @type array */
?>

<div class="producer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

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
