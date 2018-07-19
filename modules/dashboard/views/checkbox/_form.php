<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Checkbox */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="checkbox-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList($categoryList,[
        'prompt' => '-- Не выбрано --',
        'selected' => ($model->category_id) ? $model->category_id : '',
//        'disabled' => ($model->isNewRecord) ? false : true
    ]) ?>
    <?= $form->field($model, 'active')->checkbox(['checked ' => true]) ?>

    <?php if ($model->isNewRecord): ?>
        <?= $form->field($model, 'allCategory')->checkbox() ?>
    <?php endif;?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn did btn-outline']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
