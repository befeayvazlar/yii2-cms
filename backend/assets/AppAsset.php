<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'libs/bower/font-awesome/css/font-awesome.min.css',
        'libs/bower/material-design-iconic-font/dist/css/material-design-iconic-font.css',
        /** build:css ../assets/css/app.min.css */
        'libs/bower/animate.css/animate.min.css',
        'libs/bower/fullcalendar/dist/fullcalendar.min.css',
        'libs/bower/perfect-scrollbar/css/perfect-scrollbar.css',
        'css/bootstrap.css',
        'css/core.css',
        'css/misc-pages.css',
        'css/bootstrap4-validation.css',
        'css/app.css',
        /** endbuild */
        'https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,800,900,300'
    ];
    public $js = [
        /** build:js ../assets/js/core.min.js */
        //'libs/bower/jquery/dist/jquery.js',
        'libs/bower/jquery-ui/jquery-ui.min.js',
        'libs/bower/jQuery-Storage-API/jquery.storageapi.min.js',
        'libs/bower/bootstrap-sass/assets/javascripts/bootstrap.js',
        'libs/bower/jquery-slimscroll/jquery.slimscroll.js',
        'libs/bower/perfect-scrollbar/js/perfect-scrollbar.jquery.js',
        'libs/bower/PACE/pace.min.js',
        /** endbuild */
        /** build:js ../assets/js/app.min.js  */
        'js/library.js',
        'js/plugins.js',
        'js/app.js',
        /** endbuild */
        'libs/bower/moment/moment.js',
        'libs/bower/fullcalendar/dist/fullcalendar.min.js',
        'js/fullcalendar.js',
        'libs/sweetalert2/dist/sweetalert2.all.min.js',
        'libs/izitoast/dist/js/iziToast.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        JqueryAsset::class,
        'yii\bootstrap4\BootstrapAsset',
    ];
}
