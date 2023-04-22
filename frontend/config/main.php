<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'techplait',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '__tpcsrf',
            'class' => 'common\components\Request',
            'route_web' => '/frontend/web',
        ],
        'paypal'=> [
            'class'        => 'davidjeddy\Paypal',
            'clientId'     => 'AYaMWd7boid-c7wN21QZW_-we_fpKlHln_n3ZLAxSUlr8h44TnXFs4TnxlUM6_42GpcaUvdA20t9wuhq',
            'clientSecret' => 'EOC34m_hYwrngqFP3MqkHEopzpMskSPkx2XVLhGYpjIA-D15hgEfy2R6m4odYxHlbEe75YBzXtX6ZQGu',
            'isProduction' => false,
            'config'       => [
                'http.ConnectionTimeOut' => 30,
                'http.Retry'             => 1,
                'mode'                   => \davidjeddy\Paypal::MODE_SANDBOX,
                'log.LogEnabled'         => YII_DEBUG ? 1 : 0,
                'log.FileName'           => '@runtime/logs/paypal.log',
                'log.LogLevel'           => \davidjeddy\Paypal::LOG_LEVEL_FINE,
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '__tpbinary', 'httpOnly' => true],
        ],
        'session' => [
            'name' => '__tpbinary_sess',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'pattern' => 'register/ref/<ref>',
                    'route' => 'site/register',
                ],
                [
                    'pattern' => 'tp/<action>',
                    'route' => 'site/<action>'
                ],
                [
                    'pattern' => 'organization/genealogy/<startFrom>',
                    'route' => 'organization/genealogy',
                ],
            ],
        ],
        'formatter' => [
            'decimalSeparator' => ',',
            'thousandSeparator' => ',',
            'currencyCode' => 'NGN',
        ],
    ],
    'params' => $params,
];
