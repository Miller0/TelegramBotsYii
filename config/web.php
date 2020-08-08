<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$urlRules = require __DIR__ . '/urlRules.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),

    'bootstrap' => [
        //'log',
        //'debug',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'saejgmfowqmflmsdoujvno23j48jrejfgmqadmiopS**Tjgowgjmvoijfoiqoirfvz',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => $urlRules,
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'authItem',
            'itemChildTable' => 'authItemChild',
            'assignmentTable' => 'authAssignment',
            'ruleTable' => 'authRule',
            'defaultRoles' => ['guest'],
        ],

        //https://yiiframework.com.ua/ru/doc/guide/2/tutorial-performance-tuning/#optimizing-session
        //'session' => [
        //   'class' => 'yii\web\DbSession',
        //  'sessionTable' => 'my_session',
        //],
    ],
    'params' => $params,

    'modules' => [
        'telegram' => [
            'class' => 'app\modules\telegram\Module',
        ],
    ],
];

if (YII_ENV_DEV)
{
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
