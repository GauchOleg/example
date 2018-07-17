<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Cart */

$this->title = Yii::t('app', 'Обновить заказ: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);

$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index'], 'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'id' => $model->id],'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = 'Обновление заказа "' .$model->order_id . '"';
?>
<div class="cart-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
