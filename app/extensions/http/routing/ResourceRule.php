<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\http\routing;

use yii\base\InvalidConfigException;
use yii\helpers\Inflector;
use yii\web\CompositeUrlRule;
use yii\web\UrlRuleInterface;

/**
 * Class ResourceRule automatically creates the URL rules for a resource controller
 *
 * Example:
 *    'GET posts' => 'post/index',
 *    'POST posts' => 'post/store',
 *    'GET posts/<id>' => 'post/view',
 *    'GET posts/<id>/edit' => 'post/edit',
 *    'POST posts/<id>' => 'post/update',
 *    'DELETE posts/<id>' => 'post/destroy',
 *
 * @package app\extensions\http\routing
 */
class ResourceRule extends CompositeUrlRule
{
    /**
     * Resource controller name/id
     * @var string
     */
    public $controller;

    /**
     * Enables an inflection on a controller name in the URL
     * @var bool
     */
    public $pluralize;

    /**
     * Controller key to search models
     * @var string
     */
    protected $token = 'id';

    /**
     * URL prefix
     * @var string
     */
    protected $prefix;

    /**
     * Additional rules for resource controller
     * @var RouterRule[]
     */
    protected $extraRules = [];

    /**
     * Defaults resource controller routes
     * @return array
     */
    protected function resourceRules()
    {
        return [
            // GET controller => controller/index
            Router::get("", "index"),
            // POST controller => controller/store
            Router::post("", "store"),

            // GET controller/<id> => controller/view
            Router::get("<{$this->token}>", "view"),
            // GET controller/<id>/edit => controller/edit
            Router::get("<{$this->token}>/edit", "edit"),
            // POST controller/<id> => controller/update
            Router::post("<{$this->token}>", "update"),
            // DELETE controller/<id> => controller/delete
            Router::delete("<{$this->token}>", "delete"),
        ];
    }

    /**
     * URL rules normalization
     *
     * @param array $rules
     *
     * @throws InvalidConfigException
     */
    protected function normalizeRules(array $rules)
    {
        // build full controller URL prefix
        $normalizedPrefix = $this->pluralize
            ? Inflector::pluralize($this->controller)
            : $this->controller;

        // append custom prefix if exists
        if ($this->prefix) {
            $normalizedPrefix = "{$this->prefix}/{$normalizedPrefix}";
        }

        // normalize each rule
        foreach ($rules as $rule) {
            // check rules class
            if (!$rule instanceof RouterRule) {
                throw new InvalidConfigException('All rules must be an instance of RouterRule class');
            }

            // set URL prefix
            $rule->pattern = rtrim("{$normalizedPrefix}/{$rule->pattern}", '/');

            // append controller path to the actions
            $rule->route = "{$this->controller}/{$rule->route}";

            $rule->build();
        }
    }

    /**
     * Builds all of the resource controller routes
     */
    public function build()
    {
        $this->rules = array_merge(
            $this->resourceRules(),
            $this->extraRules
        );
    }

    /**
     * Creates the URL rules for a resource controller
     *
     * @return UrlRuleInterface[] the URL rules
     * @throws InvalidConfigException
     */
    protected function createRules()
    {
        return $this->normalizeRules($this->rules);
    }

    /**
     * Changes resources primary key name
     *
     * @param string $name
     *
     * @return $this
     */
    public function token(string $name)
    {
        $this->token = $name;

        return $this;
    }

    /**
     * Appends custom prefix to the URL route
     *
     * @param string $urlPrefix
     *
     * @return $this
     */
    public function prefix(string $urlPrefix)
    {
        $this->prefix = $urlPrefix;

        return $this;
    }

    /**
     * Appends custom URL rules to the resource controller
     *
     * @param RouterRule[] $rules
     *
     * @return $this
     */
    public function extra(array $rules)
    {
        $this->extraRules = $rules;

        return $this;
    }
}