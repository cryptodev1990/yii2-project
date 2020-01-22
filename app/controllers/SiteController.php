<?php

declare(strict_types=1);

namespace app\controllers;

use manchenkov\yii\http\Controller;

class SiteController extends Controller
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