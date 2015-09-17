<?php

use yii\helpers\ArrayHelper;

$sfCommon = __DIR__ . DIRECTORY_SEPARATOR . 'common.php';
$sfCommonLoc = __DIR__ . DIRECTORY_SEPARATOR . 'common-local.php';
$sfWebLoc = __DIR__ . DIRECTORY_SEPARATOR . 'web-local.php';

$webConfig = [
    'id' => 'messages.tdd',
    'language' => 'ru',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'SG8U5kXDGFCg5X9br5A-NuwKfztN5vLT',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
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
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
    ],
];

return ArrayHelper::merge(
    require($sfCommon),
    file_exists($sfCommonLoc) ? require($sfCommonLoc) : [],
    $webConfig,
    file_exists($sfWebLoc) ? require($sfWebLoc) : []
);


