<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Authentication page asset bundle.
 */
class AuthAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'fonts/icomoon/icomoon.css',
        'css/main.css',
        'css/custom.css',
        'vendor/notify/notify-flat.css',
    ];
    public $js = [
        'https://code.jquery.com/jquery-migrate-3.0.0.min.js',
        'js/tether.min.js',
        'js/bootstrap.min.js',
        'vendor/unifyMenu/unifyMenu.js',
        'vendor/onoffcanvas/onoffcanvas.js',
        'js/moment.js',
        
        'vendor/slimscroll/slimscroll.min.js',
        'vendor/slimscroll/custom-scrollbar.js',
        
        'js/common.js',
        'js/jquery.easing.1.3.js',
        'vendor/notify/notify.js',
        'js/techplait.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
