<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\modules\dashboard\assets\BackendGlobalAsset;
use app\modules\dashboard\assets\DashboardAsset;
use app\modules\dashboard\widgets\Alert;

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
        <link rel="shortcut icon" href="/favico.png" type="image/png">
        <?php $this->head() ?>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
    <?php $this->beginBody() ?>
    <!-- BEGIN HEADER -->
    <?= $this->render('_elements/header'); ?>
    <!-- END HEADER -->

    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->

    <!-- BEGIN CONTAINER -->
    <div class="page-container">

        <!-- BEGIN SIDEBAR -->
        <?php
//        if(\Yii::$app->user->can('admin') || Yii::$app->user->can('admin-did') || Yii::$app->user->can('admin-mcb') || Yii::$app->user->can('admin-all')){
            echo $this->render('_elements/main-menu');
//        }elseif(\Yii::$app->user->can('USER')){
//            echo $this->render('_elements/staff-main-menu');
//        }else{
//            echo $this->render('_elements/client-main-menu');
//        }
        ?>
        <!-- END SIDEBAR -->

        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN PAGE BAR -->
                <?php if(!Yii::$app->user->isGuest) : ?>
                    <div class="page-bar">
                        <?php
                        if (isset($this->params['breadcrumbs']) && count($this->params['breadcrumbs']) > 0) {
                            $this->params['breadcrumbs'] = array_merge([[
                                'label' => 'Home',
                                'url' => '/dashboard',
                                'template' => '<li> {link} <i class="fa fa-circle"></i></li>',
                            ]], $this->params['breadcrumbs']);
                        } else {
                            $this->params['breadcrumbs'] = [[
                                'label' => 'Home',
                                'url' => '/dashboard',
                                'template' => '<li> {link}</li>',
                            ]];
                        }

                        echo yii\widgets\Breadcrumbs::widget([
                            'options' => [
                                'class' => 'page-breadcrumb'
                            ],
                            'homeLink' => false,
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ])
                        ?>

                        <div class="page-toolbar"></div>
                    </div>

                <?php endif; ?>
                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
                <h3 class="page-title">
                    <?= isset($this->params['pageTitle']) ? $this->params['pageTitle'] : '' ?> <small><?= isset($this->params['pageSmallTitle']) ? $this->params['pageSmallTitle'] : '' ?></small>
                </h3>
                <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->
<!--                --><?//= Alert::widget() ?>
                <?= $content ?>
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->

    </div>
    <!-- END CONTAINER -->

    <?= $this->render('_elements/footer'); ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>