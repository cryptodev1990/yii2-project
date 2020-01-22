<?php

declare(strict_types=1);

namespace app\controllers\api;

use manchenkov\yii\http\Controller;
use yii\base\Exception;
use yii\web\Response;

class ExampleController extends Controller
{
    /**
     * Returns random string
     * @return Response
     * @throws Exception
     */
    public function actionLoadText(): Response
    {
        return $this->asJson(
            app()->security->generateRandomString()
        );
    }
}