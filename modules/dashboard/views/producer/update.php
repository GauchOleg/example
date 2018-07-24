<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Producer */
/* @var $statusList \app\modules\dashboard\models\Producer @type array */

$this->title = 'Обновить производителя: ' . $model->name;

$this->params['breadcrumbs'][] = ['label' => 'Производители', 'url' => ['index'], 'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id],'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = 'Обновление производителя "' .$model->name . '"';

?>
<div class="producer-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'statusList' => $statusList
    ]) ?>

</div>
