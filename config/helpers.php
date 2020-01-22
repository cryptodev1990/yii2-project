<?php

use yii\helpers\Html;

/**
 * Returns SeoHelper component of $app
 * @return manchenkov\yii\http\Seo|null
 */
function seo()
{
    return app()->seo ?: null;
}

/**
 * Helper to include assets in the view with version suffix (cache solution)
 *
 * @param string $filename
 *
 * @return string
 */
function asset(string $filename)
{
    $timestamp = @filemtime(
        alias("@public/{$filename}")
    );

    $filename = ($timestamp)
        ? "{$filename}?v={$timestamp}"
        : $filename;

    return url($filename);
}

/**
 * Helper to generate HTML form CSRF input field
 * @return string
 */
function csrf()
{
    [$param, $token] = [request()->csrfParam, request()->csrfToken];

    return Html::input('hidden', $param, $token);
}