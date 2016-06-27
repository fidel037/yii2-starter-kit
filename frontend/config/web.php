<?php
$config = [
    'homeUrl'             => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute'        => 'site/index',
    'bootstrap'           => ['maintenance'],
    'modules'             => [
        'user'   => [
            'class' => 'frontend\modules\user\Module',
            //'shouldBeActivated' => true
        ],
        'oauth2' => [
            'class'               => 'filsh\yii2\oauth2server\Module',
            'tokenParamName'      => 'accessToken',
            'tokenAccessLifetime' => 3600 * 24,
            'storageMap'          => [
                'user_credentials' => 'frontend\modules\api\v1\resources\User',
            ],
            'grantTypes'          => [
                'user_credentials' => [
                    'class' => 'OAuth2\GrantType\UserCredentials',
                ],
                'refresh_token'    => [
                    'class'                          => 'OAuth2\GrantType\RefreshToken',
                    'always_issue_new_refresh_token' => true,
                ],
            ],
        ],
        'api'    => [
            'class'   => 'frontend\modules\api\Module',
            'modules' => [
                'v1' => 'frontend\modules\api\v1\Module',
            ],
        ],
    ],
    'components'          => [
        'urlManager'           => [
            'enablePrettyUrl' => true,
            'rules'           => [
                'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'article'],
            ],
        ],
        'authClientCollection' => [
            'class'   => 'yii\authclient\Collection',
            'clients' => [
                'github'   => [
                    'class'        => 'yii\authclient\clients\GitHub',
                    'clientId'     => env('GITHUB_CLIENT_ID'),
                    'clientSecret' => env('GITHUB_CLIENT_SECRET'),
                ],
                'facebook' => [
                    'class'          => 'yii\authclient\clients\Facebook',
                    'clientId'       => env('FACEBOOK_CLIENT_ID'),
                    'clientSecret'   => env('FACEBOOK_CLIENT_SECRET'),
                    'scope'          => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name',
                    ],
                ],
            ],
        ],
        'errorHandler'         => [
            'errorAction' => 'site/error',
        ],
        'maintenance'          => [
            'class'   => 'common\components\maintenance\Maintenance',
            'enabled' => function ($app) {
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            },
        ],
        'request'              => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY'),
            'baseUrl'             => '',
            'parsers'             => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user'                 => [
            'class'           => 'yii\web\User',
            'identityClass'   => 'common\models\User',
            'loginUrl'        => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin'   => 'common\behaviors\LoginTimestampBehavior',
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class'           => 'yii\gii\generators\crud\Generator',
                'messageCategory' => 'frontend',
            ],
        ],
    ];
}

return $config;
