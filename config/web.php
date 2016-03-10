<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id'         => 'basic',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'aliases'    => [
        '@pathToWeb' => '/'
    ],
    'modules'    => [
        'admin' => [
            'class'      => 'app\modules\admin\Module',
            'layoutPath' => 'modules/admin/views/layouts',
            'layout'     => 'main'
        ],
    ],
    'components' => [

        //'db'           => require(__DIR__ . '/db.php'),

        'db'           => require(__DIR__ . '/db_localhost.php'),

        'request'      => [
            'cookieValidationKey' => 'c-NHMnDZ9sbiYk1VCtpPDXb8Yrjhhtt4',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager'   => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => false,
            'suffix'              => '.html',
            'rules'               => [
                //'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                [
                    'pattern' => '',
                    'route'   => 'site/index',
                    'suffix'  => ''
                ],
                [
                    'pattern' => '<action>/page/<page:\d+>',
                    'route'   => 'site/<action>'
                ],
                '<action>' => 'site/<action>',
                [
                    'pattern' => 'master/<id:\d+>-<name>/comment-page/<page:\d+>',
                    'route'   => 'masters/person'
                ],
                [
                    'pattern' => 'master/<id:\d+>-<name>',
                    'route'   => 'masters/person'
                ],
                [
                    'pattern' => 'master/<id:\d+>-<name>/add-comment',
                    'route'   => 'masters/comment'
                ],
                [
                    'pattern' => 'information/all/page/<page:\d+>',
                    'route'   => 'information/index'
                ],
                [
                    'pattern' => 'information/<id:\d+>-<title>',
                    'route'   => 'information/information-full'
                ],
                [
                    'pattern' => 'information/all',
                    'route'   => 'information/index'
                ],
                [
                    'pattern' => '<controller>/<action>/page/<page:\d+>',
                    'route'   => '<controller>/<action>'
                ],
                [
                    'pattern' => '<controller>/<action>/<id:\d+>',
                    'route'   => '<controller>/<action>'
                ],
                [
                    'pattern' => 'sitemap',
                    'route'   => 'sitemap/index',
                    'suffix'  => '.xml'
                ]
            ],

        ],
    ],
    'params'     => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
