<?php

/**
 * Weather plugin for Craft CMS 4.x
 *
 * Returns the current weather conditions for a lat and long coordinate pair. Requires valid Open Weather Maps API key.
 *
 * @link      https://simplygoodwork.com
 * @copyright Copyright (c) 2022 Good Work
 */

namespace simplygoodwork\weather;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\helpers\UrlHelper;
use simplygoodwork\weather\models\Settings;

class WeatherPlugin extends Plugin
{
    public static WeatherPlugin $plugin;

    public string $schemaVersion = '1.0.0';

    public bool $hasCpSettings = true;

    public bool $hasCpSection = false;

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Custom initialization code goes here...
    }

    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    protected function settingsHtml(): ?string
    {
        $view = Craft::$app->getView();

        return $view->renderTemplate('weather/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
