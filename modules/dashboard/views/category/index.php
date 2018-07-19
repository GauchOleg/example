<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\dashboard\searchModels\CategorytSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

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
//            'parent_id',
            'name',
            'alias',
//            'image',
            [
                'attribute' => 'image',
                'value' => function($model){
                    return $model->getFileImage();
                },
                'format' => 'raw',
                'headerOptions' => ['style' => 'min-width:60px;width:60px'],
            ],
//            'text:ntext',
            [
                'attribute' => 'text',
                'value' => function($model) {
                    return trim(strip_tags(mb_strimwidth(trim(strip_tags($model->text)), 0, 45, "...")));
                },
                'format' => 'raw'
            ],
            //'seo_title',
            //'seo_keywords',
            //'seo_description',

//            ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{notifications} {view} {update} {delete}',
                'headerOptions' => ['style' => 'min-width:320px;width:320px'],
                'header' => 'Actions',
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
