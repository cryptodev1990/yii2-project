<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\maker\actions;

use app\extensions\maker\commands\MakeAction;
use yii\helpers\StringHelper;

class ResourceAction extends MakeAction
{
    /**
     * Generates files for a new resource: migration, model, controller
     *
     * @param string $name
     */
    public function run(string $name)
    {
        // create a migration
        app()->runAction('make/migration', [StringHelper::basename($name)]);

        // create a model
        app()->runAction('make/model', [$name]);

        // create a controller
        app()->runAction('make/controller', [$name . 'Controller', true]);
    }
}