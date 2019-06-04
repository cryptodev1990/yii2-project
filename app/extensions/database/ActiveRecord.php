<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\database;

use yii\db\ActiveRecord as AR;
use yii\web\NotFoundHttpException;

/**
 * Custom application ActiveRecord class wrapper with additional methods
 */
class ActiveRecord extends AR
{
    /**
     * The method with automatic exception throwing when not found a model
     *
     * @param $condition
     *
     * @return ActiveRecord|null
     * @throws NotFoundHttpException
     */
    public static function findOrFail($condition)
    {
        $model = static::findOne($condition);

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Returns a custom ActiveQuery object to work with queries
     * @return ActiveQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        $query = new ActiveQuery(static::class);

        return $query;
    }
}