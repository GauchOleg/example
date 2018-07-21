<?php
/* @var $this yii\web\View */
/* @var $metaData \app\modules\dashboard\models\MetaData @type array */
/* @var $model \app\modules\dashboard\models\MetaData */



use yii\helpers\Html;


$this->title = 'Контент';
$this->params['breadcrumbs'][] = $this->title;
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

<?php $form = \yii\widgets\ActiveForm::begin(); ?>

<?php echo $this->render('section-service',[
    'metaData' => $metaData,
])?>

<?php echo $this->render('section-sale',[
    'metaData' => $metaData,
])?>

<?php echo $this->render('section-about',[
    'metaData' => $metaData,
])?>

<?php echo $this->render('section-contact',[
    'metaData' => $metaData,
])?>

<div class="form-group">
    <?= Html::submitButton('Обновить', ['class' => 'btn did btn-outline']) ?>
</div>

<?php \yii\widgets\ActiveForm::end(); ?>