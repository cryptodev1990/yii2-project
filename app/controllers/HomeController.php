<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\controllers;

use app\core\filters\AccessFilter;
use app\extensions\http\Controller;

/**
 * Class HomeController for provide user personal account management
 * @package App\Controllers\Auth
 */
class HomeController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessFilter::class,
                'rules' => $this->accessRules(),
            ],
        ];
    }

    /**
     * @return array
     */
    private function accessRules()
    {
        return [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
    }

    public function actionMe()
    {
        return view('home');
    }
}