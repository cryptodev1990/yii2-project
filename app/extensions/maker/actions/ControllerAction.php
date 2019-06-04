<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\maker\actions;

use app\extensions\maker\commands\MakeAction;
use yii\helpers\StringHelper;

class ControllerAction extends MakeAction
{
    /**
     * Generates a new HTTP controller class
     *
     * @param string $name
     * @param bool $isResource
     */
    public function run(string $name, bool $isResource = false)
    {
        // base namespace
        $namespace = "app\\controllers";
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

        // select controller template
        $template = $isResource ? "resource" : "http";

        // generate file content
        return $this->process(
            [
                "namespace" => $namespace,
                "class" => $class,
            ],
            [
                "controllers/{$template}.md" => "controllers/{$filename}.php",
            ]
        );
    }
}