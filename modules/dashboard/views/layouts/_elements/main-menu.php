<?php
/* @var \yii\web\View $this */

use app\modules\booking\models\Notification;
?>

<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->


        <?php
        $controller = $this->context->id;
        $module = $this->context->module->id;

        echo yii\widgets\Menu::widget([
            'encodeLabels' => false,
            'activateParents' => true,
            'submenuTemplate' => "\n<ul class=\"sub-menu\">\n{items}\n</ul>\n",
            'options' => [
                'class' => 'page-sidebar-menu  page-header-fixed',
                'data-auto-scroll' => 'true',
                'data-slide-speed' => 200,
                'style' => 'padding-top: 20px',
                'data-keep-expanded' => false,
            ],
            'items' => [

                [
                    'label' => '<i class="icon-home"></i> <span class="title"> ' . Yii::t('app', 'Главная') . '</span>',
                    'url' => ['/dashboard/backend/index'],
                    'options' => [
                        'class' => 'start'
                    ],
                ],
                [
                    'label' => '<i class="fa fa-list-ul"></i> <span class="title"> ' . Yii::t('app', 'Категории') . '</span>',
                    'url' => ['/dashboard/category/index'],
                    'options' => [
                        'class' => 'start'
                    ],
                ],
                [
                    'label' => '<i class="fa fa-folder-open"></i> <span class="title"> ' . Yii::t('app', 'Товары') . '</span>',
                    'url' => ['/dashboard/product/index'],
                    'options' => [
                        'class' => 'start'
                    ],
                ],
                [
                    'label' => '<i class="fa fa-cogs"></i> <span class="title"> ' . Yii::t('app', 'Настройки') . '</span>',
                    'url' => ['/booking/settings/index'],
                    'options' => [
                        'class' => 'start'
                    ],
                ],
            ]
        ]);
        ?>

        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>