<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\FrontendAsset;

FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/frontend/images/ico/apple-touch-icon-144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/frontend/images/ico/apple-touch-icon-114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/frontend/images/apple-touch-icon-72.png">
    <link rel="apple-touch-icon-precomposed" href="/frontend/images/ico/apple-touch-icon-57.png">
    <link rel="shortcut icon" href="/frontend/images/ico/favicon.ico">
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<!-- navigation render -->
<?php echo $this->render('navigation')?>
<!-- end navigation render -->
<!-- content -->
<?php echo $content;?>
<!-- end content -->
<!-- Footer section start -->
<?php echo $this->render('footer');?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>