<?php

namespace app\modules\dashboard\assets;

use yii\web\AssetBundle;

class BackendGlobalAsset extends AssetBundle
{
    public $basePath = '@webroot/backend/';
//    public $baseUrl = '@web';

    public $css = [
        '//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',

        'backend/global/plugins/datatables/datatables.min.css',
        'backend/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
        'backend/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css',

        'backend/global/plugins/jqvmap/jqvmap/jqvmap.css',

        'backend/layouts/layout/css/layout.min.css',
        'backend/layouts/layout/css/themes/darkblue.min.css',
        'backend/layouts/layout/css/custom.min.css',

//        'css/admin.css',
    ];

    public $js = [
        'backend/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
    ];

    public $depends = [
        'app\assets\YiiAssets',
        'yii\bootstrap\BootstrapAsset'
    ];

    public function init()
    {
        parent::init();
        // resetting BootstrapAsset to not load own css files
        \Yii::$app->assetManager->bundles['yii\\web\\JqueryAsset'] = [
            'css' => [],
            'js' => []
        ];
        \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapPluginAsset'] = [
//            'css' => [],
            'js' => []
        ];
    }
}