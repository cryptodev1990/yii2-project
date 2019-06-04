<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\core\helpers;

use Manchenkov\Yii\Recaptcha\ReCaptchaWidget;
use yii\base\BaseObject;
use yii\base\Model;

class TwigHelper extends BaseObject
{
    public static function functions()
    {
        return [
            // url() and path() already installed by default

            't' => 't', // Translate with i18n
            'dd' => 'dd', // Dump and die
            'seo' => 'seo', // Returns SEO component
            'user' => 'user', // Returns User component
            'asset' => 'asset', // Include files with timestamp suffix
            'config' => 'config', // Get application config value by $key argument
            'session' => 'session', // Returns session component
            'request' => 'request', // Returns request component

            // custom TwigHelper functions
            'csrf' => self::csrf(),
            'reCaptcha' => self::reCaptcha(),

            'form_field' => self::form_field(),
            'form_label' => self::form_label(),
            'form_errors' => self::form_errors(),
            'form_error' => self::form_error(),

            'is_granted' => self::is_granted(),
        ];
    }

    /**
     * Helper to work with CSRF token
     * @return \Closure
     */
    private static function csrf()
    {
        return function ($asMeta = false) {
            $param = request()->csrfParam;
            $token = request()->csrfToken;

            if ($asMeta) {
                $content = "<meta name='csrf-param' content='{$param}'>";
                $content .= "<meta name='csrf-token' content='{$token}'>";
            } else {
                $content = "<input type='hidden' name='{$param}' value='{$token}'>";
            }

            return $content;
        };
    }

    /**
     * Generates a name for a model form attribute
     * @return \Closure
     */
    private static function form_field()
    {
        return function (Model $model, string $attribute) {
            $formName = $model->formName();

            return "{$formName}[{$attribute}]";
        };
    }

    /**
     * Returns a label for a model form attribute
     * @return \Closure
     */
    private static function form_label()
    {
        return function (Model $model, string $attribute) {
            return $model->attributeLabels()[$attribute];
        };
    }

    /**
     * Returns an error messages of the form
     * @return \Closure
     */
    private static function form_errors()
    {
        return function (Model $model) {
            $errors = [];

            foreach ($model->errors as $attr => $attrErrors) {
                $errors = array_merge($errors, $attrErrors);
            }

            return $errors;
        };
    }

    /**
     * Returns an error message for $attribute of the $model form
     * @return \Closure
     */
    private static function form_error()
    {
        return function (Model $model, string $attribute) {
            return $model->getFirstError($attribute);
        };
    }

    /**
     * Returns Google reCAPTCHA v3 hidden input
     * @return \Closure
     */
    public static function reCaptcha()
    {
        return function (Model $form, string $attribute, string $action = 'homepage', bool $showBadge = true) {
            return ReCaptchaWidget::widget([
                'model' => $form,
                'action' => $action,
                'attribute' => $attribute,
                'showBadge' => $showBadge,
            ]);
        };
    }

    /**
     * Checks current user permissions and returns true|false
     * @return \Closure
     */
    private static function is_granted()
    {
        return function (string $permission) {
            return user()->can($permission);
        };
    }
}