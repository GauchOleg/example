<?php

namespace app\modules\dashboard\assets;

use yii\web\AssetBundle;

class BackendGlobalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        '//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
        'global/plugins/font-awesome/css/font-awesome.min.css',
        'global/plugins/simple-line-icons/simple-line-icons.min.css',
        'global/plugins/bootstrap/css/bootstrap.min.css',
        'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css',
        'global/plugins/bootstrap-modal/css/bootstrap-modal.css',
        'global/plugins/uniform/css/uniform.default.css',

        'global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        'global/plugins/select2/css/select2.min.css',
        'global/plugins/select2/css/select2-bootstrap.min.css',
        'global/plugins/bootstrap-touchspin/bootstrap.touchspin.min.css',
        'global/plugins/clockface/css/clockface.css',

        // editable
        'global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css',

        'global/css/components.min.css',
        'global/css/plugins.min.css',
        'pages/css/login.min.css',

        'global/plugins/fullcalendar/fullcalendar.min.css',
        'global/plugins/bootstrap-editable/inputs-ext/wysihtml5/wysihtml5-align.css',
        '/global/plugins/bootstrap-editable/inputs-ext/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.css',
    ];

    public $js = [
        'global/plugins/bootstrap/js/bootstrap.min.js',
        'global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
        'global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'global/plugins/bootstrap-modal/js/bootstrap-modal.js',
        'global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js',
        'global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
        'global/plugins/js.cookie.min.js',
        'global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'global/plugins/jquery.blockui.min.js',
        'global/plugins/uniform/jquery.uniform.min.js',

        'global/plugins/select2/js/select2.min.js',
        'global/plugins/bootstrap-touchspin/bootstrap.touchspin.min.js',
        'global/plugins/clockface/js/clockface.js',

        'global/plugins/morris/morris.min.js',

        'global/plugins/jquery-validation/js/jquery.validate.min.js',
        'global/plugins/jquery-validation/js/additional-methods.min.js',
        'global/plugins/select2/js/select2.full.min.js',
        //'pages/scripts/login.min.js',

        'global/plugins/fullcalendar/lib/moment.min.js',
        'global/plugins/fullcalendar/fullcalendar.min.js',
        'global/plugins/counterup/jquery.waypoints.min.js',
        'global/plugins/counterup/jquery.counterup.min.js',

        // editable
        'global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'app\modules\dashboard\assets\DashboardAsset'
    ];
}