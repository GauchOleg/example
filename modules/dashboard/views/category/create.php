<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Category */

$this->title = 'Добавить категорию';
$this->params['breadcrumbs'][] = ['label' => 'Категории ', 'url' => ['index'], 'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
