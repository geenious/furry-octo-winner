<?php

namespace simplygoodwork\weather\controllers;

use Craft;
use craft\web\Controller;
use GuzzleHttp;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class CurrentWeatherController extends Controller
{
  public function actionGetWeather(): Response
  {
    $this->requireSiteRequest();

    $client = new GuzzleHttp\Client();
    $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather', [
      'query' => [
        'lat' => '28.0268742',
        'lon' => '-97.1158471',
        'units' => 'imperial',
        'appid' => 'f71ca27686d3b702743df02a72e6914b'
      ]
    ]);
    $responseBody = json_decode($response->getBody(), true);

    return $this->asJson($responseBody);
  }
}