<?php

namespace simplygoodwork\weather\models;

use craft\base\Model;
use DateTime;

class WeatherModel extends Model
{
  public ?string $location;
  public ?int $temp;
  public ?string $unit;
  public ?string $iconUrl;
  public ?string $dateUpdated;
}