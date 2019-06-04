<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

/**
 * Main HTTP application configuration file
 */
return [
    'id' => 'app-http',

    'name' => env('APP_NAME'),
    'charset' => env('APP_CHARSET'),
    'language' => env('APP_LANGUAGE'),

    'controllerNamespace' => 'app\controllers',

    // disables default view layout (for Twig @extends support)
    'layout' => false,

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
    'container' => require __DIR__ . '/common/container.php',

    /**
     * Application components
     */
    'components' => require __DIR__ . '/components.php',

    /**
     * Application parameters
     */
    'params' => require __DIR__ . '/common/params.php',
];