<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\maker\actions;

use app\extensions\maker\commands\MakeAction;
use yii\helpers\StringHelper;

class SeedAction extends MakeAction
{
    /**
     * Generates a new database Seeder class
     *
     * @param string $name
     */
    public function run(string $name)
    {
        // base namespace
        $namespace = "app\\database\\seeders";
        // get class base name from full path
        $class = stringy(StringHelper::basename($name))->upperCamelize();
        // build file path in lower case and append class base name
        $filename = stringy($name)
            ->replace($class, false)
            ->toLowerCase()
            ->append($class);

        // check file name suffix
        if (!$class->endsWith("Seeder")) {
            return $this->error("The file name must contain 'Seeder' suffix");
        }

        // append namespace parts if exists
        if ($name != $class) {
            $namespace .= stringy($name)
                ->replace($class, false)
                ->trimRight("/")
                ->replace("/", "\\")
                ->prepend("\\")
                ->toLowerCase();
        }

        // generate file content
        return $this->process(
            [
                "namespace" => $namespace,
                "class" => $class,
            ],
            [
                "database/seed.md" => "database/seeders/{$filename}.php",
            ]
        );
    }
}