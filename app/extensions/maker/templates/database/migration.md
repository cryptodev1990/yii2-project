<?php

use yii\db\Migration;

class {{class}} extends Migration
{
    // TODO: change the table name
    private $tableName = "TABLE_NAME";

    /**
     * Setup migration
     * @return bool|void
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),

            // TODO: define your columns below

            // timestamps
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),

            // soft delete attribute
            'deleted_at' => $this->integer(),

            // JSON additional data attribute
            'data' => $this->json(),
        ]);
    }

    /**
    * Rollback migration
    * @return bool|void
    */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}