<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FrontendAsset extends AssetBundle
{
    public $sourcePath = '@webroot/frontend/';
    public $css = [
        '//fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext',
        'css/bootstrap.css',
        'css/bootstrap-responsive.css',
        'css/style.css',
        'css/pluton.css',
        'css/pluton-ie7.css',
        'css/jquery.cslider.css',
        'css/jquery.bxslider.css',
        'css/animate.css',
        'css/custom.css'
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $js = [
//        '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js',
        'js/jquery.js',
        'js/jquery.mixitup.js',
        'js/bootstrap.js',
        'js/modernizr.custom.js',
        'js/jquery.bxslider.js',
        'js/jquery.cslider.js',
        'js/jquery.placeholder.js',
        'js/jquery.inview.js',
        'js/respond.min.js',
//        '//maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap',
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];
}
