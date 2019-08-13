<?php

namespace app\controllers\api;

use app\extensions\http\Controller;
use yii\base\Exception;
use yii\web\Response;

class ExampleController extends Controller
{
    /**
     * Returns random string
     * @return Response
     * @throws Exception
     */
    public function actionLoadText()
    {
        return $this->asJson(
            app()->security->generateRandomString()
        );
    }
}