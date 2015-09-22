<?php

use yii\helpers\ArrayHelper;

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

// $params = require(__DIR__ . '/params.php');
// $db = require(__DIR__ . '/db.php');

$sfCommon = __DIR__ . DIRECTORY_SEPARATOR . 'common.php';
$sfCommonLoc = __DIR__ . DIRECTORY_SEPARATOR . 'common-local.php';
$sfConsolLoc = __DIR__ . DIRECTORY_SEPARATOR . 'console-local.php';
/*
return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
*/
$consConfig = [
    'id' => 'message-console',
    'bootstrap' => ['gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
];

return ArrayHelper::merge(
    require($sfCommon),
    file_exists($sfCommonLoc) ? require($sfCommonLoc) : [],
    $consConfig,
    file_exists($sfConsolLoc) ? require($sfConsolLoc) : []
);

