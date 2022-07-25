<?php

namespace simplygoodwork\weather\records;

use craft\db\ActiveRecord;

class WeatherRecord extends ActiveRecord
{
  public static function tableName(): string
  {
    return '{{%weather}}';
  }
}