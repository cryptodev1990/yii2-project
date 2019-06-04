<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\commands;

use app\extensions\console\Command;

/**
 * App state management controller
 * Here You can combine other console actions and run it as a group
 *
 * @package App\Commands
 */
class AppController extends Command
{
    /**
     * Executes Application actions array
     *
     * @param array $actions
     */
    private function runSequence(array $actions)
    {
        foreach ($actions as $action) {
            $command = $action[0];
            $params = $action[1] ?? [];

            app()->runAction($command, $params);
        }
    }

    /**
     * Loads basic application environment and data
     */
    public function actionInit()
    {
        // base commands to init application on a new hosting
        $this->runSequence([
            ['migrate', ['interactive' => 0]],
            ['seed/user'],
            ['seed/rbac'],
        ]);
    }

    /**
     * Resets and prepares application for use
     */
    public function actionReset()
    {
        // commands to reset current configurations and data removing
        $this->runSequence([
            ['migrate/fresh', ['interactive' => 0]],
            ['app/init'],
        ]);
    }
}