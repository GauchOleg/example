<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'headerOptions' => ['style' => 'min-width:100px;width:100px'],
            'attribute' => 'order_id',
            'value' => 'order_id',
        ],
        'date_ordered',
        [
            'attribute' => 'delivery',
            'value' => function($model){
                return $model->getDelivery();
            }
        ],

        [
            'attribute' => 'status',
            'value' => function($model) {
                return $model->checkStatus();
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'product_info',
            'format' => 'raw',
            'value' => function($model){
                return $model->printOrderInfo();
            },
        ],
    ],
]); ?>
