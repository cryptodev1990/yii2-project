<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\http\routing;

use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\web\UrlManager;
use yii\web\UrlRuleInterface;

/**
 * Class Router for generate application URL rules
 * @package app\extensions\http\routing
 */
class Router extends UrlManager
{
    /**
     * Base URL request path
     * @var string
     */
    public $baseUrl = '/';

    /**
     * Enable routing with params
     * @var bool
     */
    public $enablePrettyUrl = true;

    /**
     * Disable routing without matches
     * @var bool
     */
    public $enableStrictParsing = true;

    /**
     * Disable 'index.php' visibility
     * @var bool
     */
    public $showScriptName = false;

    /**
     * Directory with routes configuration files
     * @var string
     */
    public $routesDirectory;

    /**
     * Router configuration files loading
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!is_dir($this->routesDirectory)) {
            throw new InvalidConfigException('Routes directory not found');
        }

        $files = FileHelper::findFiles($this->routesDirectory);
        $rules = [];

        // load config files into array
        foreach ($files as $f) {
            $loadedRules = require $f;

            if (is_array($loadedRules)) {
                $rules = array_merge(
                    $rules,
                    $loadedRules
                );
            } else {
                // single rule (like Group)
                $rules[] = $loadedRules;
            }
        }

        // save the rules to the current router array
        $this->addRules(
        // ignore incorrect values
            array_filter($rules, function ($ruleItem) {
                return $ruleItem instanceof UrlRuleInterface;
            })
        );

        // build each rules config
        foreach ($this->rules as $rule) {
            /** @var $rule RouterRule|ResourceRule|RouterGroupRule */
            $rule->build();
        }

        // initialize router component
        return parent::init();
    }

    /**
     * Builds a route object
     *
     * @param string $method
     * @param string $url
     * @param string $action
     *
     * @return RouterRule
     */
    private static function buildRule(string $method, string $url, string $action)
    {
        $config = [
            'pattern' => $url,
            'route' => $action,
        ];

        if ($method) {
            $config['verb'] = $method;
        }

        return new RouterRule($config);
    }

    /**
     * Builds a group of routes objects
     *
     * @param string $urlPrefix
     * @param string|null $routePrefix
     *
     * @return RouterGroupRule
     */
    public static function group(string $urlPrefix, string $routePrefix = null)
    {
        return new RouterGroupRule([
            'prefix' => $urlPrefix,
            'routePrefix' => $routePrefix ?? $urlPrefix,
        ]);
    }

    /**
     * Builds a predefined resource template route object
     *
     * @param string $controller
     * @param bool $pluralize
     *
     * @return ResourceRule
     */
    public static function resource(string $controller, bool $pluralize = true)
    {
        return new ResourceRule([
            'controller' => $controller,
            'pluralize' => $pluralize,
        ]);
    }

    /**
     * Returns a GET rule object
     *
     * @param string $route
     * @param string $action
     *
     * @return RouterRule
     */
    public static function get(string $route, string $action)
    {
        return self::buildRule('get', $route, $action);
    }

    /**
     * Returns a POST rule object
     *
     * @param string $route
     * @param string $action
     *
     * @return RouterRule
     */
    public static function post(string $route, string $action)
    {
        return self::buildRule('post', $route, $action);
    }

    /**
     * Returns a PUT rule object
     *
     * @param string $route
     * @param string $action
     *
     * @return RouterRule
     */
    public static function put(string $route, string $action)
    {
        return self::buildRule('put', $route, $action);
    }

    /**
     * Returns a PATCH rule object
     *
     * @param string $route
     * @param string $action
     *
     * @return RouterRule
     */
    public static function patch(string $route, string $action)
    {
        return self::buildRule('patch', $route, $action);
    }

    /**
     * Returns a DELETE rule object
     *
     * @param string $route
     * @param string $action
     *
     * @return RouterRule
     */
    public static function delete(string $route, string $action)
    {
        return self::buildRule('delete', $route, $action);
    }

    /**
     * Returns a rule object for any of REQUEST method types
     *
     * @param string $route
     * @param string $action
     *
     * @return RouterRule
     */
    public static function any(string $route, string $action)
    {
        return self::buildRule(false, $route, $action);
    }

    /**
     * Returns a rule object to handle multiple REQUEST method types
     *
     * @param array $methods
     * @param string $route
     * @param string $action
     *
     * @return RouterRule
     */
    public static function matches(array $methods, string $route, string $action)
    {
        $methods = implode(',', $methods);

        return self::buildRule($methods, $route, $action);
    }
}