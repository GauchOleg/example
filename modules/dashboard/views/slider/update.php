<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Slider */

$this->title = 'Update Slider: ' . $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Слайдера', 'url' => ['index'], 'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id],'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = 'Обновление слайдера "' .$model->title . '"';

?>
<div class="slider-update">

    <?= $this->render('_form', [
        'model' => $model,
        'statusList' => $statusList,
    ]) ?>

</div>
