<?php

use yii\helpers\Html;
use app\modules\dashboard\assets\DashboardAsset;

/* @var $this \yii\web\View */
/* @var $content string */

DashboardAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="login">

    <?php $this->beginBody() ?>

    <!-- BEGIN LOGO -->
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                </div>
            </div>

            <div class="content">
                <?= $content ?>
            </div>

        </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>