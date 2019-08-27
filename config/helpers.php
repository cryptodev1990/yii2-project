<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

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