<?php

/* @var $comment \app\modules\dashboard\models\Comment @type model */
/* @var $statusList \app\modules\dashboard\models\Comment @type array */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(); ?>
<?php echo $form->field($comment,'active')->dropDownList($statusList,['class' => 'form-control'])?>
<?php echo Html::submitButton('Одобрить',['class' => 'btn btn-outline did add-cart'])?>
<?php ActiveForm::end(); ?>
