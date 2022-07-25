<?php

namespace simplygoodwork\weather\controllers;

use Craft;
use craft\web\Controller;
use simplygoodwork\weather\WeatherPlugin;
use yii\web\Response;

class SettingsController extends Controller
{
  public function actionSaveSettings(): Response
  {
    $this->requirePostRequest();

    $request = Craft::$app->getRequest();

    $data = [
      'lat' => $request->getRequiredParam('lat'),
      'lon' => $request->getRequiredParam('lon'),
      'units' => $request->getRequiredParam('units'),
      'cache' => $request->getRequiredParam('cache')
    ];

    WeatherPlugin::$plugin->weather->saveSettings($data);

    return $this->redirectToPostedUrl();
  }
}