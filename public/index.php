<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use yii\base\InvalidConfigException;
use yii\web\Application;

// Load environments configuration
$env = Dotenv::create(dirname(__DIR__));

try {
    $env->load();
} catch (\Exception $error) {
    alert("App environment initialization failed");
    die();
}

define('YII_DEBUG', env('APP_DEBUG')); // false
define('YII_ENV', env('APP_ENV')); // prod

// register current hostname to $_ENV
env('HOST', $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST']);

// Load Yii applications requirements
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../config/aliases.php';

$config = require __DIR__ . '/../config/http.php';

// Try to start application
try {
    $app = new Application($config);
    $app->run();
} catch (InvalidConfigException $exception) {
    echo 'Invalid app configuration';

    if (YII_ENV_DEV) {
        echo ": " . $exception->getMessage();
    }
}
