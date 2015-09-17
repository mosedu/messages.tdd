<?php

use yii\helpers\ArrayHelper;

$sfParams = __DIR__ . DIRECTORY_SEPARATOR . 'params-local.php';

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    file_exists($sfParams) ? require($sfParams) : []
);
// $params = require(__DIR__ . '/params.php');

$config = [
    'basePath' => dirname(__DIR__),
    'name' => 'Информационная система сопровождения деятельности по информированию об услугах дошкольного образования и комплектования образовательных организаций',
    'bootstrap' => ['log'],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
//        'authManager' => [
//            'class' => 'yii\rbac\PhpManager',
//            'defaultRoles' => ['another' , 'maintainer'], //
//        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'cache' => false,
            'rules' => [
                '<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>' => '<_c>/index',
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@app/views/mail',
            'htmlLayout' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
        ],
    ],
    'params' => $params,
];

return $config;
