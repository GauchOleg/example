<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index'],'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn did btn-outline']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn did btn-outline',
            'data' => [
                'confirm' => 'Удалить эту категорию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
                'format' => 'raw'
            ],
            [
                'attribute' => 'text',
                'value' => function($model) {
                    return trim(strip_tags(mb_strimwidth(trim(strip_tags($model->text)), 0, 45, "...")));
                },
                'format' => 'raw'
            ],
//            'text:ntext',
            'seo_title',
            'seo_keywords',
            'seo_description',
        ],
    ]) ?>

</div>
