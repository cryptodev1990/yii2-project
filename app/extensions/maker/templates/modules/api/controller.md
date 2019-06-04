<?php

namespace app\modules\api\controllers;

use app\extensions\http\Controller;
use app\extensions\http\rest\Middleware;

class MainController extends Controller
{
    use Middleware;

    /**
     * AccessControl rules
     * @return array
     *
     * @example
     * ```php
     * return [
     *     [
     *         'allow' => true|false,
     *         'roles' => ['?'],
     *         'action' => ['index', 'action']
     *     ],
     * ];
     * ```
     */
    protected function accessRules()
    {
        return [];
    }

    /**
     * Array of actions without authentication
     * @return array
     */
    protected function publicActions()
    {
        return [];
    }

    public function actionIndex()
    {
        return 'API module loaded!';
    }
}