<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Cart */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заказы'), 'url' => ['index'], 'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-view">

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn did btn-outline']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn did btn-outline',
            'data' => [
                'confirm' => 'Удалить этот товар?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'order_id',
//            'product_info:ntext',
            'customer_name',
            'customer_phone',
//            'customer_email:email',
//            'status',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatus();
                }
            ],
//            'session_id',
            'finished',
            'create_at',
            'update_at',
            'customer_l_name',
            'customer_o_name',
//            'product_code',
            'address',
//            'product_id',
//            'count',
//            'delivery',
            [
                'attribute' => 'delivery',
                'value' => function($model){
                    return $model->getDelivery();
                }
            ],
//            'prices',
            'total_price',
        ],
    ]) ?>

</div>
