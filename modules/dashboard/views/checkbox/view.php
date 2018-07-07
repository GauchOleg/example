<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Checkbox */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Метки (чекбоксы)', 'url' => ['index'], 'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkbox-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn did btn-outline']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn did btn-outline',
            'data' => [
                'confirm' => 'Удалить этот чекбокс?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
//            'category_id',
//            'active',
            [
                'attribute' => 'category_id',
                'value' => function($model){
                    return $model->getCategoryName();
                },
            ],
            [
                'attribute' => 'Активен',
                'value' => function($model) {
                    return $model->checkActive();
                },
                'format' => 'raw',
            ]
        ],
    ]) ?>

</div>
