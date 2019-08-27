<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\maker\actions;

use app\extensions\maker\commands\MakeAction;
use yii\helpers\StringHelper;

class ApiAction extends MakeAction
{
    /**
     * Generates a new application module
     *
     * @param string $name
     *
     * @return int|void
     */
    public function run(string $name)
    {
        // base namespace
        $namespace = "app\\modules\\";

        // module base name
        $module = stringy($name)->toLowerCase();

        // routes config name
        $routesConfig = StringHelper::basename($module);

        // append namespace parts
        $namespace .= $module->replace("/", "\\");

        // generate file content
        return $this->process(
            [
                "namespace" => $namespace,
                "routes" => $routesConfig,
                "module" => $module,
            ],
            [
                "modules/basic/controller.md" => "modules/{$module}/controllers/MainController.php",
                "modules/basic/module.md" => "modules/{$module}/Module.php",
                "modules/basic/routes.md" => "routes/{$routesConfig}.php",
            ]
        );
    }
}