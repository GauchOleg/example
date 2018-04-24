<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Product */

$this->title = 'Добавть товар';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index'],'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'categoryList' => $categoryList,
    ]) ?>

</div>
