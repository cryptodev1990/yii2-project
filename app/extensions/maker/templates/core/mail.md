<?php

namespace {{namespace}};

use app\extensions\mail\Mailable;
use yii\base\BaseObject;

class {{class}} extends BaseObject implements Mailable
{
    /**
     * Returns a prepared data to compose mail view (use in `send()` method)
     * @return array
     */
    public function data(): array
    {
        return [];
    }

    /**
     * Returns a sender email with name
     * @return array
     */
    public function from(): array
    {
        return [config('email.no-reply') => app()->name];
    }

    /**
     * Returns a receiver email
     * @return string
     */
    public function to(): string
    {
        return '';
    }

    /**
     * Returns a subject string value
     * @return string
     */
    public function subject(): string
    {
        return t('mail', 'SubjectTitle');
    }

    /**
     * Returns a view template name
     * @return string
     */
    public function view(): string
    {
        return '';
    }
}