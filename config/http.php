<?php

/**
 * Main HTTP application configuration file
 */
return [
    'id' => 'app-http',

    'name' => env('APP_NAME'),
    'charset' => env('APP_CHARSET'),
    'language' => env('APP_LANGUAGE'),

    'controllerNamespace' => 'app\controllers',

    'basePath' => '@app',
    'vendorPath' => '@vendor',
    'viewPath' => '@resources/views',
    'runtimePath' => '@runtime',

    /**
     * Components and modules for pre-loading
     */
    'bootstrap' => [
        'log',
    ],

    /**
     * Application modules
     */
    'modules' => [
        // modules configuration will be here
    ],

    /**
     * Dependency Injection container
     */
    'container' => require __DIR__ . '/container.php',

    /**
     * Application parameters
     */
    'params' => require __DIR__ . '/params.php',

    /**
     * Application components
     */
    'components' => yii\helpers\ArrayHelper::merge(
        require __DIR__ . '/common.php',

        // current application components only
        [
            /**
             * Web Request component
             */
            'request' => [
                'class' => manchenkov\yii\http\InternationalRequest::class,
                'baseUrl' => '',
                'cookieValidationKey' => env('SESSION_KEY'),
                'csrfParam' => '_csrf',
                //'languages' => ['ru', 'en'],
            ],

            /**
             * User identity component
             */
            'user' => [
                'identityClass' => app\models\auth\User::class,
                'enableAutoLogin' => true,

                'identityCookie' => [
                    'name' => '_identity',
                    'httpOnly' => true,
                ],

                'loginUrl' => ['auth/sign/login'],
            ],

            /**
             * Social Auth component
             * Default: Facebook, Google, VK, Github
             *
             * APIs:
             * Google - https://console.developers.google.com/apis/credentials
             * Facebook - https://developers.facebook.com/apps/
             * VK - https://vk.com/apps?act=manage
             * GitHub - https://github.com/settings/developers
             */
            'authClientCollection' => [
                'class' => yii\authclient\Collection::class,
                'httpClient' => [
                    'transport' => yii\httpclient\CurlTransport::class,
                ],
                'clients' => [
                    'google' => [
                        'class' => yii\authclient\clients\Google::class,
                        'clientId' => env('GOOGLE_AUTH_CLIENT_ID'),
                        'clientSecret' => env('GOOGLE_AUTH_CLIENT_SECRET'),
                        'returnUrl' => env('HOST') . '/social-auth/google',
                    ],
                    'facebook' => [
                        'class' => yii\authclient\clients\Facebook::class,
                        'clientId' => env('FACEBOOK_AUTH_CLIENT_ID'),
                        'clientSecret' => env('FACEBOOK_AUTH_CLIENT_SECRET'),
                        'returnUrl' => env('HOST') . '/social-auth/facebook',
                    ],
                    'vk' => [
                        'class' => yii\authclient\clients\VKontakte::class,
                        'clientId' => env('VK_AUTH_CLIENT_ID'),
                        'clientSecret' => env('VK_AUTH_CLIENT_SECRET'),
                        'returnUrl' => env('HOST') . '/social-auth/vk',
                        'scope' => ['email'],
                    ],
                    'github' => [
                        'class' => yii\authclient\clients\GitHub::class,
                        'clientId' => env('GITHUB_AUTH_CLIENT_ID'),
                        'clientSecret' => env('GITHUB_AUTH_CLIENT_SECRET'),
                        'returnUrl' => env('HOST') . '/social-auth/github',
                    ],
                ],
            ],

            /**
             * Global error handler
             */
            'errorHandler' => [
                // ErrorController
                'errorAction' => 'error/index',
            ],

            /**
             * Assets file manager
             */
            'assetManager' => ['bundles' => false],

            /**
             * SEO helper component
             */
            'seo' => [
                'class' => app\core\components\Seo::class,
                'config' => require __DIR__ . '/seo.php',
            ],
        ]
    ),
];