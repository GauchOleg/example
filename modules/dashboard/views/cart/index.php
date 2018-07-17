<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\dashboard\searchModels\Cart */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Заказы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn did btn-outline']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'order_id',
//            'product_info:ntext',
            'customer_name',
            'customer_phone',
            //'customer_email:email',
            //'status',
            //'session_id',
            //'finished',
            'create_at',
            //'update_at',
            //'customer_l_name',
            //'customer_o_name',
            //'product_code',
            'address',
            //'product_id',
            //'count',
//            'delivery',
            [
                'attribute' => 'delivery',
                'value' => function($model){
                    return $model->getDelivery();
                }
            ],
            //'prices',
            'total_price',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{notifications} {view} {update} {delete}',
                'headerOptions' => ['style' => 'min-width:320px;width:320px'],
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
                            'data-confirm' => Yii::t('yii', 'Удалить категорию?'),
                        ]);
                    },
                ],
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
