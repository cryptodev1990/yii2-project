<?php

use manchenkov\yii\http\Seo;
use yii\helpers\Html;

/**
 * Returns SeoHelper component of $app
 * @return manchenkov\yii\http\Seo|null
 */
function seo(): ?Seo
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
function asset(string $filename): string
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
function csrf(): string
{
    [$param, $token] = [request()->csrfParam, request()->csrfToken];

    return Html::input('hidden', $param, $token);
}