<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\controllers;

use app\extensions\http\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class ErrorController to handle runtime errors
 */
class ErrorController extends Controller
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
        } else {
            return $this->redirect('/');
        }
    }
}