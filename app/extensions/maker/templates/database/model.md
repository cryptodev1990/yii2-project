<?php

namespace {{namespace}};

use app\extensions\database\ActiveRecord;

class {{class}} extends ActiveRecord
{
    /**
     * Data validation rules
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Additional behaviors to data processing
     * @return array
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * Attributes translation
     * @return array
     */
    public function attributeLabels()
    {
        return [];
    }
}