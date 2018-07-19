<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Slider */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Слайдера', 'url' => ['index'], 'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="slider-view">

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn did btn-outline']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn did btn-outline',
            'data' => [
                'confirm' => 'Удалить этот слайдер?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'num_id',
            'title',
            'pre_description',
            'description:ntext',
            'link',
            'status',
            'create_at',
//            'update_at',
        ],
    ]) ?>

</div>
