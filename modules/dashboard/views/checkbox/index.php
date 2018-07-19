<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\dashboard\searchModels\checkboxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Метки (чекбоксы)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkbox-index">

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
            'name',
//            [
////                'headerOptions' => ['style' => 'width:800px'],
//                'attribute' => 'Назваие',
//                'value' => 'name'
//            ],
//            'category_id',
            [
                'headerOptions' => ['style' => 'width:250px'],
                'attribute' => 'category_id',
                'value' => function($model){
                    return $model->getCategoryName();
                },
                'filter' => $categoryList
            ],
//            'active',
            [
                'headerOptions' => ['style' => 'width:50px'],
                'attribute' => 'active',
                'value' => function($model) {
                    return $model->checkActive();
                },
                'format' => 'raw',
            ],

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
