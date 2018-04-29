<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\dashboard\searchModels\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

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
//            'category_id',
            [
                'attribute' => 'category_id',
                'value' => function($model){
                    return $model->getCategoryName();
                },
                'filter' => $categoryList
            ],
            'name',
//            'alias',
            'code',
            [
                'attribute' => 'images',
                'value' => function($model) use ($productImg) {
                    return $productImg->getFirstImg($model->id);
                },
                'format' => 'raw'

            ],
            [
                'headerOptions' => ['style' => 'width:50px'],
                'attribute' => 'new',
                'value' => function($model) {
                    return $model->checkNew();
                },
                'format' => 'raw',
            ],
            [
                'headerOptions' => ['style' => 'width:50px'],
                'attribute' => 'new',
                'value' => function($model) {
                    return $model->checkSale();
                },
                'format' => 'raw',
            ],
            //'price',
            //'text:ntext',
            //'seo_title',
            //'seo_keywords',
            //'seo_description',
            //'new',
            //'sale',
            //'create_at',
            //'update_at',

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
