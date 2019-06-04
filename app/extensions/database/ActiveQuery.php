<?php
/**
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

namespace app\extensions\database;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery as AQ;
use yii\web\NotFoundHttpException;

/**
 * Custom application ActiveQuery class with ActiveCollection support
 *
 * Supports JSON columns search
 *
 * @see ActiveRecord
 */
class ActiveQuery extends AQ
{
    /**
     * Gets an ActiveRecord primary key name
     * @return mixed
     */
    private function primaryKey()
    {
        /** @var ActiveRecord $record */
        $record = get_class($this->primaryModel);

        return $record::primaryKey()[0] ?? null;
    }

    /**
     * Gets IDs of result records
     * @return array
     * @throws InvalidConfigException
     */
    public function ids()
    {
        $pk = $this->primaryKey();

        if ($pk) {
            return $this->select($pk)->column();
        } else {
            throw new InvalidConfigException("Primary Key not found");
        }
    }

    /**
     * Filter by PK column
     *
     * @param int $id
     *
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function byID(int $id)
    {
        $pk = $this->primaryKey();

        if ($pk) {
            return $this->andWhere([$pk => $id]);
        } else {
            throw new InvalidConfigException("Primary Key not found");
        }
    }

    /**
     * Throws NotFound error if no such model were found
     * @return array|null|ActiveRecord
     * @throws NotFoundHttpException
     */
    public function oneOrFail()
    {
        $model = $this->one();

        if ($model) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * Checks if JSON key contains in a column value
     *
     * @param string $column
     * @param $key
     *
     * @return ActiveQuery
     */
    public function jsonKeyExists(string $column, $key)
    {
        return $this->jsonWhere($column, $key, 'NULL', 'IS NOT');
    }

    /**
     * Search method for JSON columns
     *
     * @param string $column
     * @param string $key
     * @param $value
     * @param string $operator
     *
     * @return ActiveQuery
     */
    public function jsonWhere(string $column, string $key, $value, string $operator = '=')
    {
        if (is_array($value) && $operator == '=') {
            $operator = 'in';
            $value = "(" . implode(',', $value) . ")";
        }

        if (is_integer($key)) {
            $key = "$[{$key}]";
        } else {
            $key = "$.{$key}";
        }

        // column->>'$[0]' = value
        // column->>'$.key' = value
        // column->>'$.key' > value
        // column->>'$.key' in (value1, value2, value3)

        $expression = "{$column}->>'{$key}' {$operator} {$value}";

        return $this->andWhere($expression);
    }

    /**
     * Creates a new ActiveCollection instance with query results
     *
     * @param array $records
     *
     * @return ActiveCollection
     */
    protected function collection(array $records)
    {
        return new ActiveCollection($records, $this->modelClass);
    }

    /**
     * Returns result of a query set
     *
     * @param null $db
     *
     * @return ActiveCollection|array|\yii\db\ActiveRecord[]
     */
    public function all($db = null)
    {
        $data = parent::all($db);

        return ($this->asArray) ? $data : $this->collection($data);
    }
}