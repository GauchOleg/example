<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index'], 'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn did btn-outline']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn did btn-outline',
            'data' => [
                'confirm' => 'Удалить этот товар?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'category_id',
            [
                'attribute' => 'category_id',
                'value' => function($model){
                    return $model->getCategoryName();
                }
            ],
            'name',
            [
                'attribute' => 'checkboxes',
                'value' => function($model){
                    return $model->getCheckboxById();
                }
            ],
            [
                'attribute' => 'images',
                'value' => function($model) use ($productImg) {
                    return $productImg->getImg($model->id,false,false,'cart');
                },
                'format' => 'raw'

            ],
            'alias',
            'code',
            'price',
            'text:ntext',
            'seo_title',
            'seo_keywords',
            'seo_description',
//            'new',
            [
                'attribute' => 'new',
                'value' => function($model) {
                    return $model->checkNew();
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'sale',
                'value' => function($model) {
                    return $model->checkSale();
                },
                'format' => 'raw',
            ],
//            'sale',
            'create_at',
            'update_at',
        ],
    ]) ?>

</div>
