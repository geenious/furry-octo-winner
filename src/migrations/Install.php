<?php

namespace simplygoodwork\weather\migrations;

use Craft;
use craft\db\Migration;
use simplygoodwork\weather\records\WeatherRecord;

class Install extends Migration
{
  public function safeUp(): bool
  {
    $table = WeatherRecord::tableName();

    if (!$this->db->tableExists($table)) {
      $this->createTable($table, [
        'id' => $this->primaryKey(),
        'lat' => $this->string()->notNull(),
        'lon' => $this->string()->notNull(),
        'units' => $this->string()->notNull(),
        'cache' => $this->integer()->defaultValue(60)->notNull(),
        'dateCreated' => $this->dateTime()->notNull(),
        'dateUpdated' => $this->dateTime()->notNull(),
        'uid' => $this->uid(),
      ]);

      Craft::$app->db->schema->refresh();
    }

    return true;
  }

  public function safeDown(): bool
  {
    $this->dropTableIfExists('{{%weather}}');

    return true;
  }
}