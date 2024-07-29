<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$db_lis = require __DIR__ . '/db_lis.php';
$db_ihs = require __DIR__ . '/db_ihs.php';
$db_jaspel = require __DIR__ . '/db_jaspel.php';
$db_pembayaran = require __DIR__ . '/db_pembayaran.php';
$db_lis_bridging = require __DIR__ . '/db_lis_bridging.php';
$db_berkas = require __DIR__ . '/db_berkas.php';
$db_regonline = require __DIR__ . '/db_regonline.php';
$db_erm = require __DIR__ . '/db_erm.php';

$config = [
    'id' => 'gos2_plus',
    'timeZone' => 'Asia/Jakarta',
    'name' => 'SimGos2 Plus',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'as access' => [
        'class' => '\hscstudio\mimin\components\AccessControl',
        'allowActions' => [
            // add wildcard allowed action here!
            'site/*',
            'antrian/print-label/*',
            'rsudapi/*', // untuk API tetep harus buka, walaupun buka saat akan akses tetap akan di mintai bearer token
        ],
    ],
    'modules' => [
        'mimin' => [
            'class' => '\hscstudio\mimin\Module',
        ],
        'apm' => [
            'class' => 'app\modules\apm\Module',
            'layout' => 'apm'
        ],
        'rsudapi' => [
            'class' => 'app\modules\rsudapi\Module',
        ],
        'lis' => [
            'class' => 'app\modules\lis\Module',
        ],
        'jaspel' => [
            'class' => 'app\modules\jaspel\Module',
        ],
        'pembayaran' => [
            'class' => 'app\modules\pembayaran\Module',
        ],
        'laporan' => [
            'class' => 'app\modules\laporan\Module',
        ],
        'berkas' => [
            'class' => 'app\modules\berkas\Module',
        ],
        'antrian' => [
            'class' => 'app\modules\antrian\Module',
        ],
        'ihs' => [
            'class' => 'app\modules\ihs\Module',
        ],
        'erm' => [
            'class' => 'app\modules\erm\Module',
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // only support DbManager
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '-0isBabrtVV0H3cqQYcLDRc_gHIaV20P',
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
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db_lis' => $db_lis,
        'db_jaspel' => $db_jaspel,
        'db_pembayaran' => $db_pembayaran,
        'db_lis_bridging' => $db_lis_bridging,
        'db_berkas' => $db_berkas,
        'db_regonline' => $db_regonline,
        'db_ihs' => $db_ihs,
        'db_erm' => $db_erm,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
