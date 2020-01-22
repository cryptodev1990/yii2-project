<?php

declare(strict_types=1);

namespace app\core\interfaces;

use SplFileInfo;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\web\UploadedFile;

interface Storage
{
    /**
     * Creates new directory at relative $path
     *
     * @param string $path
     *
     * @return bool
     * @throws Exception
     */
    public function createDirectory(string $path): bool;

    /**
     * Deletes selected directory at relative $path
     *
     * @param string $path
     *
     * @throws ErrorException
     */
    public function deleteDirectory(string $path): void;

    /**
     * Clears directory content (re-creation)
     *
     * @param string $path
     *
     * @return bool
     * @throws ErrorException
     * @throws Exception
     */
    public function clearDirectory(string $path): bool;

    /**
     * Saves file to passed $directory path
     *
     * @param string $directory
     * @param UploadedFile $file
     *
     * @return bool|string Returns relative file path if succeeded or false
     */
    public function add(string $directory, UploadedFile $file);

    /**
     * Stores new file with a given content
     *
     * @param string $directory
     * @param string $filename
     * @param $content
     *
     * @return bool|string
     */
    public function store(string $directory, string $filename, $content);

    /**
     * Deletes file by passed path
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete(string $path): bool;

    /**
     * Copies file from absolute $path to relative $newPath
     *
     * @param string $path
     * @param string $newPath
     *
     * @return bool
     */
    public function copy(string $path, string $newPath): bool;

    /**
     * Moves file from absolute $path to new relative $newPath
     *
     * @param string $path
     * @param string $newPath
     *
     * @return bool
     */
    public function move(string $path, string $newPath): bool;

    /**
     * Returns URL for passed relative $filename
     *
     * @param string $filename
     * @param bool $absolute
     *
     * @return string
     */
    public function url(string $filename, bool $absolute = false): string;

    /**
     * Returns SplFileInfo object for passed $filename
     *
     * @param string $filename
     *
     * @return SplFileInfo
     */
    public function fileInfo(string $filename): SplFileInfo;

    /**
     * Returns array with 'directories' and 'files' keys which contains founded items
     *
     * @param string $directory
     *
     * @return array
     */
    public function all(string $directory): array;

    /**
     * Returns array of subdirectories in the passed directory
     *
     * @param string $directory
     *
     * @return array
     */
    public function directories(string $directory): array;

    /**
     * Returns array of files in the passed directory
     *
     * @param string $directory
     *
     * @return array
     */
    public function files(string $directory): array;
}