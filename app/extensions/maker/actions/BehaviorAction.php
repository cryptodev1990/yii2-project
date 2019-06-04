<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\maker\actions;

use app\extensions\maker\commands\MakeAction;
use yii\helpers\StringHelper;

class BehaviorAction extends MakeAction
{
    /**
     * Generates a new Behavior component class
     *
     * @param string $name
     */
    public function run(string $name)
    {
        // base namespace
        $namespace = "app\\core\\behaviors";
        // get class base name from full path
        $class = stringy(StringHelper::basename($name))->upperCamelize();
        // build file path in lower case and append class base name
        $filename = stringy($name)
            ->replace($class, false)
            ->toLowerCase()
            ->append($class);

        // check file name suffix
        if (!$class->endsWith("Behavior")) {
            return $this->error("The file name must contain 'Behavior' suffix");
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
                "core/behavior.md" => "core/behaviors/{$filename}.php",
            ]
        );
    }
}