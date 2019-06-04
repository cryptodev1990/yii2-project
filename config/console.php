<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

/**
 * Created by Artem Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

/**
 * Main CLI application configuration file
 */
return [
    'id' => 'app-console',

    'language' => env('APP_LANGUAGE'),
    'charset' => env('APP_CHARSET'),
    'name' => env('APP_NAME'),

    'controllerNamespace' => 'app\commands',

    'controllerMap' => [
        // custom configuration
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => [
                // Application migrations
                '@app/database/migrations',

                //'@yii/caching/migrations',
                //'@yii/log/migrations',
                '@yii/rbac/migrations',
            ],
        ],
        'serve' => [
            'class' => \yii\console\controllers\ServeController::class,
            'docroot' => '@public'
        ],
        'make' => [
            'class' => \app\extensions\maker\commands\MakeController::class,
        ],
    ],

    'basePath' => '@app',
    'vendorPath' => '@vendor',
    'viewPath' => '@resources/views',
    'runtimePath' => '@runtime',

    /**
     * Components and modules for pre-loading
     */
    'bootstrap' => [],

    /**
     * Application modules
     */
    'modules' => [],

    /**
     * Dependency Injection container
     */
    'container' => require __DIR__ . '/common/container.php',

    /**
     * Application components
     */
    'components' => [
        /**
         * Database connection
         */
        'db' => require __DIR__ . '/common/db.php',

        /**
         * Mailer component
         */
        'mailer' => require __DIR__ . '/common/mail.php',

        /**
         * Application cache component
         */
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],

        /**
         * Application logger component
         */
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        /**
         * RBAC component settings
         */
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
        ],
    ],

    /**
     * Application parameters
     */
    'params' => require __DIR__ . '/common/params.php',
];
