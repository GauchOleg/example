<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\dashboard\searchModels\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;

$js = <<< JS
    $('.status').click(function(e) {
        e.preventDefault();
        $('#comment-view-modal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
JS;
$this->registerJs($js);

?>
<div class="product-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        --><?//= Html::a('Создать', ['create'], ['class' => 'btn did btn-outline']) ?>
<!--    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'headerOptions' => ['style' => 'min-width:150px;width:150px'],
                'attribute' => 'username',
                'value' => 'username',
            ],
            [
                'attribute' => 'text',
                'value' => 'text'
            ],
            [
                'headerOptions' => ['style' => 'min-width:50px;width:50px'],
                'attribute' => 'active',
                'value' => function($model){
                    return $model->getActiveStatus();
                },
                'format' => 'raw'
            ],
            [
                'attribute' => 'product_id',
                'value' => function($model){
                    return $model->getProductLink();
                },
                'format' => 'raw',
            ],
            'create_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{notifications} {delete}',
                'headerOptions' => ['style' => 'min-width:100px;width:100px'],
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
                            'data-confirm' => Yii::t('yii', 'Удалить комментарий?'),
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
    'id' =>'comment-view-modal',
]);
yii\bootstrap\Modal::end();
?>
<script>
    $('.change-status').on('click', function(e) {
        e.preventDefault();
        $('#comment-status-modal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
</script>