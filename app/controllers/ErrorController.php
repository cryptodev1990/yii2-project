<?php

declare(strict_types=1);

namespace app\controllers;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class ErrorController to handle runtime errors
 */
final class ErrorController extends Controller
{
    /**
     * @return string|Response
     */
    public function actionIndex()
    {
        $error = app()->errorHandler->exception;

        if ($error) {
            return view(
                ($error instanceof NotFoundHttpException || $error instanceof ForbiddenHttpException)
                    ? '404'
                    : '500',
                compact('error')
            );
        }

        return $this->goHome();
    }
}