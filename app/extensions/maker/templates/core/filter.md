<?php

namespace {{namespace}};

use yii\base\ActionFilter;

class {{class}} extends ActionFilter
{
    public function beforeAction($action)
    {
        // Your code
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        // Your code
        return parent::afterAction($action, $result);
    }
}