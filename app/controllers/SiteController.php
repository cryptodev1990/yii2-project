<?php

declare(strict_types=1);

namespace app\controllers;

use yii\web\Controller;

final class SiteController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        seo()->title = 'Home page';

        return view('index');
    }
}