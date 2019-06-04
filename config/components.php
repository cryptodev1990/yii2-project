<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

return [
    /**
     * Database connection
     */
    'db' => require __DIR__ . '/common/db.php',

    /**
     * Mailer component
     */
    'mailer' => require __DIR__ . '/common/mail.php',

    /**
     * Web Request component
     */
    'request' => [
        'class' => \app\extensions\http\Request::class,
        'baseUrl' => '',
        'cookieValidationKey' => env('SESSION_KEY'),
        'csrfParam' => '_csrf',
        //'languages' => ['ru', 'en'],
    ],

    /**
     * Application router settings
     */
    'urlManager' => [
        'class' => \app\extensions\http\routing\Router::class,
        'routesDirectory' => dirname(__DIR__) . '/app/routes',
    ],

    /**
     * User identity component
     */
    'user' => [
        'identityClass' => \app\models\auth\User::class,
        'enableAutoLogin' => true,

        'identityCookie' => [
            'name' => '_identity',
            'httpOnly' => true,
        ],

        'loginUrl' => ['auth/sign/login'],
    ],

    /**
     * RBAC component settings
     */
    'authManager' => [
        'class' => \yii\rbac\DbManager::class,
    ],

    /**
     * Social Auth component
     * Default: Facebook, Google, VK, Github
     */
    'authClientCollection' => [
        'class' => yii\authclient\Collection::class,
        'httpClient' => [
            'transport' => \yii\httpclient\CurlTransport::class,
        ],
        'clients' => [
            'google' => [
                'class' => \yii\authclient\clients\Google::class,
                'clientId' => env('GOOGLE_AUTH_CLIENT_ID'),
                'clientSecret' => env('GOOGLE_AUTH_CLIENT_SECRET'),
                'returnUrl' => env('HOST') . '/social-auth/google',
            ],
            'facebook' => [
                'class' => \yii\authclient\clients\Facebook::class,
                'clientId' => env('FACEBOOK_AUTH_CLIENT_ID'),
                'clientSecret' => env('FACEBOOK_AUTH_CLIENT_SECRET'),
                'returnUrl' => env('HOST') . '/social-auth/facebook',
            ],
            'vk' => [
                'class' => \yii\authclient\clients\VKontakte::class,
                'clientId' => env('VK_AUTH_CLIENT_ID'),
                'clientSecret' => env('VK_AUTH_CLIENT_SECRET'),
                'returnUrl' => env('HOST') . '/social-auth/vk',
                'scope' => ['email'],
            ],
            'github' => [
                'class' => \yii\authclient\clients\GitHub::class,
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
     * Application cache component
     */
    'cache' => [
        'class' => \yii\caching\FileCache::class,
    ],

    /**
     * Assets file manager
     */
    'assetManager' => [
        'bundles' => false,
    ],

    /**
     * Translator component
     */
    'i18n' => [
        'translations' => [
            '*' => [
                'class' => \yii\i18n\PhpMessageSource::class,
                'basePath' => '@resources/lang',
            ],
        ],
    ],

    /**
     * Application view renderer component
     */
    'view' => [
        'class' => \yii\web\View::class,
        'defaultExtension' => 'twig',
        'renderers' => [
            'twig' => require __DIR__ . '/common/twig.php',
        ],
    ],

    /**
     * Application logger component
     */
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => \yii\log\FileTarget::class,
                'levels' => ['error', 'warning'],
            ],
        ],
    ],

    /**
     * SEO helper component
     */
    'seo' => [
        'class' => \app\extensions\http\Seo::class,
        'config' => require __DIR__ . '/seo.php',
    ],
];
