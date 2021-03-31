<?php

declare(strict_types=1);

namespace app\controllers;

use app\core\filters\AccessFilter;
use yii\web\Controller;

/**
 * Class HomeController for provide user personal account management
 * @package App\Controllers\Auth
 */
final class HomeController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
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
    private function accessRules(): array
    {
        return [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionMe(): string
    {
        return view('home');
    }
}