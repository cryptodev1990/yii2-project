<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\maker\actions;

use app\extensions\maker\commands\MakeAction;
use yii\helpers\StringHelper;

class ViewAction extends MakeAction
{
    /**
     * Generates a Twig view file
     *
     * @param string $name
     */
    public function run(string $name)
    {
        $path = "views/{$name}";
        $view = StringHelper::basename($name);

        $this->process(
            ["name" => strtolower($view)],
            ["core/view.md" => "../resources/{$path}.twig"]
        );
    }
}