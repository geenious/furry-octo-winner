<?php

namespace simplygoodwork\weather\variables;

use simplygoodwork\weather\WeatherPlugin;
use simplygoodwork\weather\models\WeatherModel;
use simplygoodwork\weather\models\LocationModel;

class WeatherVariable
{
  public function getWeather(): WeatherModel
  {
    return WeatherPlugin::$plugin->weather->getWeather();
  }

  public function getSettings(): LocationModel
  {
    return WeatherPlugin::$plugin->weather->getSettings();
  }
}