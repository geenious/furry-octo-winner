<?php

namespace simplygoodwork\weather\services;

use Craft;
use craft\helpers\App;
use craft\base\Component;
use GuzzleHttp;
use simplygoodwork\weather\models\WeatherModel;
use simplygoodwork\weather\WeatherPlugin;

class WeatherService extends Component
{
  public function getWeather(): WeatherModel
  {
    $weatherModel = new WeatherModel();

    $client = new GuzzleHttp\Client();

    $settings = WeatherPlugin::$plugin->settings;

    $queryParams = [
      'query' => [
        'lat' => '28.0268174',
        'lon' => '-97.189336',
        'units' => 'imperial',
        'appid' => App::parseEnv($settings->apiKey)
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
    $weatherModel->unit = 'imperial';

    return $weatherModel;
  }
}