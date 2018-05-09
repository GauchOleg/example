<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\FrontendAsset;

FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- <link href="favicon.ico" rel="shortcut icon" type="image/x-icon"> -->

    <script> window.jQuery || document.write('<script src="/frontend/js/jquery-1.11.2.min.js"><\/script>')</script>

    <!--[if IE]>
    <script>$(document).ready(function(){$('input, textarea').placeholder()})</script>
    <![endif]-->

    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $content ?>

<script>
    $(document).ready(function () {
        $('#active_menu_1').addClass('active');

        $("#mygallery").justifiedGallery({
            rowHeight : 420,
            lastRow : 'nojustify',
            margins : 15,
            captions: false,
            rel : 'gallery1',

        }).on('jg.complete', function () {
            $(this).find('a').colorbox({
                maxWidth : '80%',
                maxHeight : '80%',
                opacity : 0.8,
                transition : 'elastic',
                current : '',
            });
        });


    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>