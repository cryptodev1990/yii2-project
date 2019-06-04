<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\http\routing;

use yii\web\UrlRule;

class RouterRule extends UrlRule
{
    /**
     * Controller route path
     * @var string
     */
    public $route;

    /**
     * URL rule pattern
     * @var string
     */
    public $pattern;

    /**
     * Request method GET|POST|PUT...
     * @var string
     */
    public $verb;

    /**
     * Default GET parameters' values
     * @var array
     */
    public $defaults = [];

    /**
     * URL route suffix like '.html', '.php'
     * @var string
     */
    public $suffix;

    /**
     * URL route alias to quick access in the views/controllers
     * @var string
     */
    public $alias;

    /**
     * Group prefix for alias action route
     * @var string
     */
    public $prefix;

    /**
     * Void overriding
     */
    public function init()
    {
        return;
    }

    /**
     * Registers route
     * @throws \yii\base\InvalidConfigException
     */
    public function build()
    {
        if (!empty($this->prefix)) {
            $this->route = "{$this->prefix}/{$this->route}";
        }

        if (!empty($this->alias)) {
            alias("@{$this->alias}", $this->route);
        }

        parent::init();
    }

    /**
     * Sets route alias like 'home' = Url::to(['@home'])
     *
     * @param string $value
     *
     * @return $this
     */
    public function name(string $value)
    {
        $this->alias = $value;

        return $this;
    }

    /**
     * Appends a suffix to the current route
     *
     * @param string $value
     *
     * @return $this
     */
    public function suffix(string $value)
    {
        $this->suffix = $value;

        return $this;
    }

    /**
     * Sets a default GET parameters
     *
     * @param array $context
     *
     * @return $this
     */
    public function defaults(array $context = [])
    {
        $this->defaults = $context;

        return $this;
    }
}