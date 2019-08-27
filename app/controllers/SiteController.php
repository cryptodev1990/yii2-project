<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\controllers;

use manchenkov\yii\http\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        seo()->title = 'Home page';

        return view('index');
    }
}