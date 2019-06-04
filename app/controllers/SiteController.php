<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\controllers;

use app\extensions\http\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $this->seo->title = 'Home page';

        return view('index');
    }
}