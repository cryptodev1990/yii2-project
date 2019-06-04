<?php

namespace {{namespace}}\controllers;

use app\extensions\http\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        return 'Module loaded!';
    }
}