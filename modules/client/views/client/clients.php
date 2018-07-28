<?php
/* @var $dataProvider \app\modules\user\models\User; */


use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Пользователи';

$js = <<< JS
    $('.view-modal-btn').click(function(e) {
        e.preventDefault();
        $('#order-view-modal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
JS;
$this->registerJs($js);

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'headerOptions' => ['style' => 'width:100px'],
            'attribute' => 'username',
            'value' => 'username',
        ],
        [
            'headerOptions' => ['style' => 'width:50px'],
            'attribute' => 'image',
            'value' => function($model) {
                return $model->getMetaImage();
            },
            'format' => 'raw',
        ],
        'email',
//        'role',
        [
            'attribute' => 'role',
            'value' => function($model) {
                return $model->getRole();
            },
            'format' => 'raw',
        ],
        [
            'headerOptions' => ['style' => 'width:100px'],
            'attribute' => 'status',
            'value' => function($model) {
                return $model->getStatus(true);
            },
            'format' => 'raw',
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{notifications} {view} {delete}',
            'headerOptions' => ['style' => 'min-width:220px;width:220px'],
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

<?php
yii\bootstrap\Modal::begin([
//    'header' => 'Просмотр',
    'id' =>'order-view-modal',
]);
yii\bootstrap\Modal::end();

yii\bootstrap\Modal::begin([
//    'header' => 'Просмотр',
    'id' =>'client-status-modal',
]);
yii\bootstrap\Modal::end();
?>

<script>
    $('.change-status').on('click', function(e) {
        e.preventDefault();
        $('#client-status-modal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
</script>
