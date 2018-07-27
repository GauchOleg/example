<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Cart */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заказы'), 'url' => ['index'], 'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-view">

    <h2 style="text-align: center"> <?php echo $model->username?></h2>
    <!--    <p>-->
    <!--        --><?php //echo Html::a('Удалить', ['delete', 'id' => $model->id], [
    //            'class' => 'btn did btn-outline',
    //            'data' => [
    //                'confirm' => 'Удалить этот товар?',
    //                'method' => 'post',
    //            ],
    //        ]) ?>
    <!--    </p>-->
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'headerOptions' => ['style' => 'width:100px'],
                'attribute' => 'username',
                'value' => 'username',
            ],
            [
                'attribute' => 'first_name',
                'value' => function($model) {
                    return $model->getMetaFirstName();
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'last_name',
                'value' => function($model) {
                    return $model->getMetaLastName();
                },
                'format' => 'raw',
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
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatus();
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'add_phone',
                'value' => function($model) {
                    return $model->getAddPhone();
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'spam',
                'value' => function($model) {
                    return $model->getSpam();
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'about',
                'value' => function($model) {
                    return $model->getMetaAbout();
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'site',
                'value' => function($model) {
                    return $model->getMetaSite();
                },
                'format' => 'raw',
            ],


        ],
    ]) ?>

</div>