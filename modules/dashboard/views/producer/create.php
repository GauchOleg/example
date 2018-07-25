<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Producer */
/* @var $statusList \app\modules\dashboard\models\Producer @type array */

$this->title = 'Добавить производителя';
$this->params['breadcrumbs'][] = ['label' => 'Производители', 'url' => ['index'],'template' => '<li> {link} <i class="fa fa-angle-right"></i></li>'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producer-create">

    <?= $this->render('_form', [
        'model' => $model,
        'statusList' => $statusList
    ]) ?>

</div>
