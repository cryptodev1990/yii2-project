<?php
/**
 * Created by Artem Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

return [
    // basic data
    'name' => env('SEO_TITLE'),
    'logo' => asset(env('SEO_LOGO')),

    // <meta> tags
    'meta' => [
        ['name' => 'application-name', 'content' => env('SEO_TITLE')],
        ['name' => 'description', 'content' => env('SEO_DESCRIPTION')],
        ['name' => 'keywords', 'content' => env('SEO_KEYWORDS')],

        ['name' => 'google-site-verification', 'content' => env('SEO_GOOGLE_VERIFICATION')],
        ['name' => 'yandex-verification', 'content' => env('SEO_YANDEX_VERIFICATION')],

        ['name' => 'apple-mobile-web-app-capable', 'content' => 'yes'],
        ['name' => 'apple-mobile-web-app-status-bar-style', 'content' => 'black'],
    ],

    // <link> tags
    'links' => [
        ['rel' => 'icon', 'href' => asset(env('SEO_FAVICON')), 'type' => 'image/png'],
        ['rel' => 'apple-touch-icon', 'href' => asset(env('SEO_FAVICON'))],
    ],
];