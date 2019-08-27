<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\maker\actions;

use app\extensions\maker\commands\MakeAction;
use yii\helpers\StringHelper;

class CommandAction extends MakeAction
{
    /**
     * Generates a new console Command controller class
     *
     * @param string $name
     *
     * @return int|void
     */
    public function run(string $name)
    {
        // base namespace
        $namespace = "app\\commands";
        // get class base name from full path
        $class = stringy(StringHelper::basename($name))->upperCamelize();
        // build file path in lower case and append class base name
        $filename = stringy($name)
            ->replace($class, false)
            ->toLowerCase()
            ->append($class);

        // check controller name suffix
        if (!$class->endsWith("Controller")) {
            return $this->error("The file name must contain 'Controller' suffix");
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
                "controllers/command.md" => "commands/{$filename}.php",
            ]
        );
    }

}