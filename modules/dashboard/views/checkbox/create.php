<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Checkbox */
/* @var $categoryList \app\modules\dashboard\models\Category */

$this->title = 'Создать чекбокс';
$this->params['breadcrumbs'][] = ['label' => 'Метки (чекбоксы)', 'url' => ['index'],'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkbox-create">

    <?= $this->render('_form', [
        'model' => $model,
        'categoryList' => $categoryList,
    ]) ?>

</div>
