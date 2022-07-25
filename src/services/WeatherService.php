<?php

namespace simplygoodwork\weather\services;

use Craft;
use craft\helpers\App;
use craft\base\Component;
use GuzzleHttp;
use simplygoodwork\weather\WeatherPlugin;
use simplygoodwork\weather\models\WeatherModel;
use simplygoodwork\weather\models\LocationModel;
use simplygoodwork\weather\records\WeatherRecord;

class WeatherService extends Component
{
  public function getWeather(): WeatherModel
  {
    $cache = Craft::$app->getCache();

    $value = $cache->get('current-weather');

    $weatherModel = new WeatherModel();

    $weatherSettings = WeatherRecord::findOne(1);

    if (!$value) {
      $client = new GuzzleHttp\Client();
      $apiKey = WeatherPlugin::$plugin->settings->apiKey;

      $queryParams = [
        'query' => [
          'lat' => $weatherSettings->lat,
          'lon' => $weatherSettings->lon,
          'units' => $weatherSettings->units,
          'appid' => App::parseEnv($apiKey)
        ]
      ];

      $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather', $queryParams);
  
      $responseBody = json_decode($response->getBody(), true);

      $icon = $responseBody['weather'][0]['icon'];
      $iconUrl = 'https://openweathermap.org/img/wn/' . $icon . '@2x.png';
      
      $weatherModel->location = $responseBody['name'];
      $weatherModel->iconUrl = $iconUrl;
      $weatherModel->temp = $responseBody['main']['temp'];
      $weatherModel->dateUpdated = date('d-m-Y H:i:s', $responseBody['dt']);
      $weatherModel->unit = ($queryParams['query']['units'] == 'imperial' ? 'F' : 'C');

      $cache->set('current-weather', $weatherModel, $weatherSettings->cache);

      return $weatherModel;
    }

    return $value;
  }

  public function saveSettings(array $data)
  {
    $cache = Craft::$app->getCache();

    $cache->delete('current-weather');

    $weatherSettings = WeatherRecord::findOne(1);

    if ($weatherSettings) {
      $weatherSettings->setAttributes($data, false);
    }

    else {
      $weatherSettings = new WeatherRecord();
      $weatherSettings->setAttributes($data, false);
    }

    $weatherSettings->save();
  }

  public function getSettings()
  {
    $locationModel = new LocationModel;

    $locationRecord = WeatherRecord::findOne(1);

    $locationModel->lat = $locationRecord->lat;
    $locationModel->lon = $locationRecord->lon;
    $locationModel->units = $locationRecord->units;
    $locationModel->cache = $locationRecord->cache;

    return $locationModel;
  }
}