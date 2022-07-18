<?php

namespace simplygoodwork\weather\controllers;

use Craft;
use craft\helpers\App;
use craft\web\Controller;
use GuzzleHttp;
use yii\web\Response;
use simplygoodwork\weather\WeatherPlugin;

class CurrentWeatherController extends Controller
{

  protected array|bool|int $allowAnonymous = true;

  public function actionGetWeather(): Response
  {
    $this->requireSiteRequest();

    $settings = WeatherPlugin::$plugin->settings;
    // Cache Key
    $key = 'currrent-weather';

    $cache = Craft::$app->getCache();

    $value = $cache->get($key);

    $unit = [
      'unit' => $settings->units
    ];

    if ($value === false) {
      $client = new GuzzleHttp\Client();

      $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather', [
        'query' => [
          'lat' => $settings->lat,
          'lon' => $settings->lon,
          'units' => $settings->units,
          'appid' => App::parseEnv($settings->apiKey),
        ]
      ]);

      $responseBody = json_decode($response->getBody(), true);

      $cache->set($key, $responseBody, 600);

      return $this->asJson(array_merge($unit, $responseBody));
    }

    return $this->asJson(array_merge($unit, $value));
  }
}