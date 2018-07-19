<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\dashboard\searchModels\Cart */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusList \app\modules\dashboard\models\Cart */
/* @var $model \app\modules\dashboard\models\Cart */
/* @var $deliveryList \app\modules\dashboard\models\Cart */

$this->title = Yii::t('app', 'Заказы');
$this->params['breadcrumbs'][] = $this->title;

$js = <<< JS
    $('.view-modal-btn').click(function(e) {
        e.preventDefault();
        $('#order-view-modal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
JS;
$this->registerJs($js);
?>
<div class="cart-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        --><?php //echo Html::a('Создать', ['create'], ['class' => 'btn did btn-outline']) ?>
<!--    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'headerOptions' => ['style' => 'min-width:100px;width:100px'],
                'attribute' => 'order_id',
                'value' => 'order_id',
            ],
            [
                'header' => 'Полное имя',
                'attribute' => 'customer_name',
                'value' => function($model){
                    return $model->getFullName();
                }
            ],
            'customer_email',
            [
                'headerOptions' => ['style' => 'min-width:100px;width:100px'],
                'header' => 'Телефон',
                'attribute' => 'customer_phone',
                'value' => 'customer_phone'
            ],
            [
                'attribute' => 'delivery',
                'filter' => $deliveryList,
                'value' => function($model){
                    return $model->getDelivery();
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px;width:100px'],
                'attribute' => 'total_price',
                'value' => function($model){
                    return $model->getTotal();
                }
            ],
            'date_ordered',
            [
                'attribute' => 'time_order',
                'value' => function($model) {
                    return $model->checkOrderedTime();
                },
                'format' => 'raw',
            ],
            [
                'headerOptions' => ['style' => 'min-width:160px;width:100px'],
                'format' => 'raw',
                'attribute' => 'status',
                'filter' => $statusList,
                'value' => function($model) {
                    return $model->checkStatus();
                },

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{notifications} {view} {delete}',
                'headerOptions' => ['style' => 'min-width:210px;width:210px'],
                'header' => '',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('Просмотр', $url, ['class' => 'btn did btn-outline view-modal-btn']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('Обновить', $url, ['class' => 'btn did btn-outline']);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Удалить', $url, [
                            'class' => 'btn did btn-outline',
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('yii', 'Удалить заказ?'),
                        ]);
                    },
                ],
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
yii\bootstrap\Modal::begin([
//    'header' => 'Просмотр',
    'id' =>'order-view-modal',
]);
yii\bootstrap\Modal::end();
?>