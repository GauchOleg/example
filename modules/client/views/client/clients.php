<?php
/* @var $dataProvider \app\modules\user\models\User; */


use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Пльзователи'
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'username',
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
            'attribute' => 'status',
            'value' => function($model) {
                return $model->getStatus();
            },
            'format' => 'raw',
        ],

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
                        'data-confirm' => Yii::t('yii', 'Удалить заказ?'),
                    ]);
                },
            ],
        ]
    ],
]); ?>


