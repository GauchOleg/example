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

    <h2 style="text-align: center">Заказ <?php echo $model->order_id?></h2>
<!--    <p>-->
<!--        --><?php //echo Html::a('Удалить', ['delete', 'id' => $model->id], [
//            'class' => 'btn did btn-outline',
//            'data' => [
//                'confirm' => 'Удалить этот товар?',
//                'method' => 'post',
//            ],
//        ]) ?>
<!--    </p>-->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'customer_name',
            'customer_phone',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->checkStatus();
                },
                'format' => 'raw',
            ],
            'customer_l_name',
            'customer_o_name',
            'address',
            [
                'attribute' => 'delivery',
                'value' => function($model){
                    return $model->getDelivery();
                }
            ],
            [
                'attribute' => 'product_info',
                'format' => 'raw',
                'value' => function($model){
                    return $model->printOrderInfo();
                },
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px;width:100px'],
                'attribute' => 'total_price',
                'value' => function($model){
                    return $model->getTotal();
                }
            ],
            'date_ordered',
        ],
    ]) ?>

</div>
