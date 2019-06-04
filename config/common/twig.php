<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

return [
    'class' => \yii\twig\ViewRenderer::class,
    'cachePath' => '@runtime/twig/cache',

    'options' => ['auto_reload' => env('APP_DEBUG')],

    // for support {% extends '@layouts/main.twig' %}
    'twigFallbackPaths' => [
        'layouts' => '@resources/views/layouts',
        'mails' => '@resources/mail/layouts',
    ],

    // global objects and classes for using in Views
    // 'app' (Application) and 'this' (View) already passed into template
    'globals' => [
        'Url' => ['class' => \yii\helpers\Url::class],
    ],

    // global functions handlers
    'functions' => \app\core\helpers\TwigHelper::functions(),

    // global filters aliases
    'filters' => [],
];
