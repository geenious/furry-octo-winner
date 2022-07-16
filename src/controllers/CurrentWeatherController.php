<?php

namespace simplygoodwork\weather\controllers;

use Craft;
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

    // Cache Key
    $key = 'currrent-weather';

    $cache = Craft::$app->getCache();

    $value = $cache->get($key);

    if ($value === false) {

      $apiKey = WeatherPlugin::$plugin->settings->apiKey;

      $client = new GuzzleHttp\Client();

      $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather', [
        'query' => [
          'lat' => '28.0268742',
          'lon' => '-97.1158471',
          'units' => 'imperial',
          'appid' => $apiKey,
        ]
      ]);

      $responseBody = json_decode($response->getBody(), true);

      $cache->set($key, $responseBody, 600);

      return $this->asJson($responseBody);
    }

    return $this->asJson($value);
  }
}