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
                'header' => 'ФИО',
                'attribute' => 'customer_name',
                'value' => function($model){
                    return $model->getFullName();
                }
            ],
            [
                'headerOptions' => ['style' => 'min-width:100px;width:100px'],
                'header' => 'Телефон',
                'attribute' => 'customer_phone',
                'value' => 'customer_phone'
            ],
            [
                'attribute' => 'delivery',
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
                'headerOptions' => ['style' => 'min-width:100px;width:100px'],
                'format' => 'raw',
                'attribute' => 'status',
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
                            'data-confirm' => Yii::t('yii', 'Удалить категорию?'),
                        ]);
                    },
                ],
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<script>
    $(document).ready(function () {

       $('.btn-default').on('click',function(){
           $(this).popover('show');
           var button = $(this);
           $('.check').change(function(){
               $('input[name="' + $(this).attr('name') +'"]').removeAttr('checked');
               $(this).prop('checked', true);
               var old_checkbox =  $(this).data('name');
               var status = $(this).val();
               var label = $(this).data('name');
               var product_id = $(this).parent().parent('ul').data('product-id');
               var class_status = checkStatus(status);
               $.ajax({
                   url: "update-status",
                   type: "POST",
                   data: {_csrf: yii.getCsrfToken(),status: status,product_id: product_id},
                   success: function (res) {
                       if (res) {
                           button.removeAttr('class');
                           button.addClass('btn btn-default');
                           button.addClass(class_status);
                           button.children('span').html(label);

                           $('input[data-name="' + old_checkbox +'"]').attr('checked',false);
//                           $('input[data-name="' + label +'"]').prop('checked', true);

                           console.log($('input[data-name="' + old_checkbox +'"]'));

                           $('[data-name='+ label +']').prop('checked', true);
//                           button.prop('checked', true);
                           button.popover('hide');
                       }
                   },
                   error: function () {
                       console.log('some error on cart controller .. ');
                   }
               });
           });
       });

        function checkStatus(status) {
            var new_class = '';
            switch (parseInt(status)){
                case 1 : new_class = 'status-ordered';
                    break;
                case 5 : new_class = 'status-completed';
                    break;
                case 4 : new_class = 'status-in-completed';
                    break;
                case 3 : new_class = 'status-refuse';
                    break;
                case 2 : new_class = 'status-pending';
                    break;
            }
            return new_class;
        }


    });
</script>