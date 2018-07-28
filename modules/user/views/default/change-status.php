<?php
/* @var $statusList \app\modules\user\models\User @type array */
/* @var $user\app\modules\user\models\User @type object */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<h3 style="text-align: center">Изменить статус Юзера</h3>
    <?php if (Yii::$app->user->identity->getId() == $user->id): ?>
        <h2 style="text-align: center">Себе не стоит изменять статус! :)</h2>
    <?php else: ?>
        <?php $form = ActiveForm::begin(); ?>
        <?php echo $form->field($user,'status')->dropDownList($statusList,['class' => 'form-control'])?>
        <?php echo Html::submitButton('Изменить',['class' => 'btn btn-outline did add-cart'])?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
