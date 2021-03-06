<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],

    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'WVTYXs1QEBqQQUvURDi_UHJM4wSmoqsZ',
            'baseUrl' => '',
            'enableCsrfValidation'=> true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => ['/js/jquery-3.2.1.min.js'], // тут путь до Вашего экземпляра jquery
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'profile/autorization/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'targets' => [[
                'class' => 'yii\log\FileTarget',
                'levels' => ['error', 'warning'],
                'logFile' => '@runtime/logs/app.log'
            ]]
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                '' => 'profile/autorization/index',
                /**
                 * Роуты редактирования/удаления профиля
                 */
                'admin' => 'admin/profile/index',
                'admin/edit/profile/<id:\d+>' => 'admin/profile/edit-profile',
                'admin/delete/profile/' => 'admin/profile/delete-profile',
                'admin/edit/profile/photo/' => 'admin/profile/upload-photo',

                /**
                 * Роуты редактирования/удаления/добавления статей.
                 */

                'admin/articles' => 'admin/article/index',
                'admin/article/create' => 'admin/article/create-article',
                'admin/article/edit/<id:\d+>' => 'admin/article/edit-article',
                'admin/article/delete/<id:\d+>' => 'admin/article/delete-article',

                /**
                 * Роуты редактирования/удаления/добавления пользователей.
                 */

                'admin/users' => 'admin/user/index',
                'admin/user/delete/<id:\d+>' => 'admin/user/delete',
                'admin/user/ban/<id:\d+>' => 'admin/user/ban',

                /**
                 * Роут конкретной статьи
                 */
                'article/<id:\d+>' => 'article/articles/index',

                /**
                 * Роуты профиля
                 */
                'account/edit' => 'profile/private-profile/edit-page',
                'account/' => 'profile/private-profile/index',
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
