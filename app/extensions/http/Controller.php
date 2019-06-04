<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\http;

use yii\web\Controller as BaseController;

/**
 * Base Http Controller class with Action DI support and SEO helper component
 */
abstract class Controller extends BaseController
{
    /**
     * Dependency injection in action method
     */
    use ActionDependencies;

    /**
     * @var Seo SEO component
     */
    public $seo;

    /**
     * Controller constructor
     *
     * @param $id
     * @param $module
     * @param array $config
     */
    public function __construct($id, $module, array $config = [])
    {
        $id = strtolower($id);

        parent::__construct($id, $module, $config);
    }

    /**
     * Load SEO component to Controller
     *
     * @param $action
     *
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->seo = $this->module->get('seo');

        return parent::beforeAction($action);
    }

    /**
     * Redirect to another route with session flash data
     *
     * @param $url array|string
     * @param $key string
     * @param mixed $value
     *
     * @return \yii\web\Response
     */
    public function redirectWithFlash($url, string $key, $value)
    {
        session()->setFlash($key, $value);

        return $this->redirect($url);
    }
}