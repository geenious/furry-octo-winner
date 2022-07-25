<?php

namespace simplygoodwork\weather\variables;

use simplygoodwork\weather\WeatherPlugin;
use simplygoodwork\weather\models\WeatherModel;

class WeatherVariable
{
  public function getWeather(): WeatherModel
  {
    return WeatherPlugin::$plugin->weather->getWeather();
  }
}