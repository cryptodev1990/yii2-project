<?php

namespace {{namespace}};

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public $controllerNamespace = "{{namespace}}\controllers";
    
    /**
     * Configure application with custom module settings
     *
     * @param \yii\base\Action $action
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        $config = [
            'components' => [
                // Custom request rules for API
                'request' => [
                    'class' => Request::class,
                    'enableCookieValidation' => false,
                    'parsers' => [
                        'application/json' => JsonParser::class,
                    ],
                ],

                // Custom response format to use with JSON-format
                'response' => [
                    'class' => Response::class,
                    'format' => Response::FORMAT_JSON,
                    'formatters' => [
                        Response::FORMAT_JSON => [
                            'class' => JsonResponseFormatter::class,
                            'prettyPrint' => YII_DEBUG,
                            'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                        ],
                    ],
                    'on beforeSend' => function ($event) {
                        /** @var Response $response */
                        $response = $event->sender;
                        $response->format = Response::FORMAT_JSON;

                        if (!$response->isEmpty) {
                            if (!$response->isSuccessful) {
                                $response->data = [
                                    'message' => $response->data['message'],
                                    'status' => $response->data['status'],
                                ];
                            }

                            $response->data = [
                                'success' => $response->isSuccessful,
                                'data' => $response->data,
                            ];

                            $response->statusCode = $response->isSuccessful ? 200 : 400;
                        }
                    },
                ],
            ],
        ];

        Yii::configure(Yii::$app, $config);

        return parent::beforeAction($action);
    }
}