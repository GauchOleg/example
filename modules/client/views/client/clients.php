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

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <!--        <h4>Сохранено!</h4>-->
        <i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-error alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4>Ошибка!</h4>
        <i class="icon fa fa-warning"></i> <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

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
                        'data-confirm' => Yii::t('yii', 'Удалить пользователя?'),
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
