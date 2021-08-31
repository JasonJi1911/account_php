<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,

//            'suffix' => '.html',

            'rules' => [

                // 视频首页
                [
                    'pattern'   => '/',
                    'route'     => 'account/index',
                ],

                'news/<id:\d+>/detail' => 'news/detail',

                // 通用路由配置
                '<controller:[\w-]+>/<action:[\w-]+>' => '<controller>/<action>',
                '<verify:[\w-]+>.txt' => 'site/txt' //验证文件
            ],
        ],
        'api' => function () {
            return new \frontend\services\ApiService;
        },
    ],
    'params' => $params,
];
