<?php

declare(strict_types=1);

namespace app\core\services;

use app\core\interfaces\StorageInterface;
use SplFileInfo;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class StorageService for manage files and directories in 'public' folder
 * @package App\Core\Services
 */
final class StorageService implements StorageInterface
{
    /**
     * Main web application root
     */
    public string $publicPath;

    /**
     * StorageInterface path alias string
     */
    public string $storagePath;

    /**
     * Creates new directory at relative $path
     *
     * @param string $path
     *
     * @return bool
     * @throws Exception
     */
    public function createDirectory(string $path): bool
    {
        $dir = $this->basePath($path);

        return FileHelper::createDirectory($dir);
    }

    /**
     * Returns base root directory of storage (and append $path if was sent)
     *
     * @param string|null $path
     *
     * @return bool|string
     */
    private function basePath(string $path = null)
    {
        $root = $this->storagePath;

        if (!is_null($path)) {
            $root = FileHelper::normalizePath(
                "{$root}/{$path}"
            );

            $directoryName = dirname($root);

            if (!is_dir($directoryName)) {
                try {
                    FileHelper::createDirectory($directoryName);
                } catch (\Exception $exception) {
                    dd($exception);
                }
            }
        }

        return $root;
    }

    /**
     * Deletes selected directory at relative $path
     *
     * @param string $path
     *
     * @throws ErrorException
     */
    public function deleteDirectory(string $path): void
    {
        $dir = $this->basePath($path);

        FileHelper::removeDirectory($dir);
    }

    /**
     * Clears directory content (re-creation)
     *
     * @param string $path
     *
     * @return bool
     * @throws ErrorException
     * @throws Exception
     */
    public function clearDirectory(string $path): bool
    {
        $dir = $this->basePath($path);

        FileHelper::removeDirectory($dir);

        return FileHelper::createDirectory($dir);
    }

    /**
     * Saves file to passed $directory path
     *
     * @param string $directory
     * @param UploadedFile $file
     *
     * @return bool|string Returns relative file path if succeeded or false
     */
    public function add(string $directory, UploadedFile $file)
    {
        $hash = md5_file($file->tempName);

        $path = "/{$directory}/{$hash}.{$file->extension}";
        $path = FileHelper::normalizePath($path);

        if ($file->saveAs($this->basePath($path))) {
            return $path;
        }

        return false;
    }

    /**
     * Stores new file with a given content
     *
     * @param string $directory
     * @param string $filename
     * @param $content
     *
     * @return bool|string
     */
    public function store(string $directory, string $filename, $content)
    {
        $path = FileHelper::normalizePath(
            "/{$directory}/$filename"
        );

        $destination = $this->basePath($path);

        $saved = file_put_contents(
            $destination,
            $content
        );

        return $saved ? $destination : false;
    }

    /**
     * Deletes file by passed path
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete(string $path): bool
    {
        return FileHelper::unlink(
            $this->basePath($path)
        );
    }

    /**
     * Copies file from absolute $path to relative $newPath
     *
     * @param string $path
     * @param string $newPath
     *
     * @return bool
     */
    public function copy(string $path, string $newPath): bool
    {
        return copy(
            $path,
            $this->basePath($newPath)
        );
    }

    /**
     * Moves file from absolute $path to new relative $newPath
     *
     * @param string $path
     * @param string $newPath
     *
     * @return bool
     */
    public function move(string $path, string $newPath): bool
    {
        return rename(
            $path,
            $this->basePath($newPath)
        );
    }

    /**
     * Returns URL for passed relative $filename
     *
     * @param string $filename
     * @param bool $absolute
     *
     * @return string
     */
    public function url(string $filename, bool $absolute = false): string
    {
        $filename = $this->basePath($filename);
        $publicPath = $this->publicPath;

        $filename = FileHelper::normalizePath(
            str_replace($publicPath, '/', $filename)
        );

        return url($filename, $absolute);
    }

    /**
     * Returns SplFileInfo object for passed $filename
     *
     * @param string $filename
     *
     * @return SplFileInfo
     */
    public function fileInfo(string $filename): SplFileInfo
    {
        return new SplFileInfo(
            $this->basePath($filename)
        );
    }

    /**
     * Returns array with 'directories' and 'files' keys which contains founded items
     *
     * @param string $directory
     *
     * @return array
     */
    public function all(string $directory): array
    {
        $data = [];

        $data['directories'] = $this->directories($directory);
        $data['files'] = $this->files($directory);

        return $data;
    }

    /**
     * Returns array of subdirectories in the passed directory
     *
     * @param string $directory
     *
     * @return array
     */
    public function directories(string $directory): array
    {
        return FileHelper::findDirectories(
            $this->basePath($directory),
            ['recursive' => false]
        );
    }

    /**
     * Returns array of files in the passed directory
     *
     * @param string $directory
     *
     * @return array
     */
    public function files(string $directory): array
    {
        return FileHelper::findFiles(
            $this->basePath($directory),
            ['recursive' => false]
        );
    }
}