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
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;
use simplygoodwork\weather\models\SettingsModel;
use simplygoodwork\weather\services\WeatherService;
use simplygoodwork\weather\variables\WeatherVariable;
use yii\base\Event;

class WeatherPlugin extends Plugin
{
    public static WeatherPlugin $plugin;

    public static function config(): array
    {
        return [
            'components' => [
                'weather' => ['class' => WeatherService::class]
            ]
        ];
    }

    public string $schemaVersion = '1.0.0';

    public bool $hasCpSettings = true;

    public bool $hasCpSection = true;

    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function(Event $event) {
            $variable = $event->sender;
            $variable->set('weather', WeatherVariable::class);
        });
    }

    protected function createSettingsModel(): SettingsModel
    {
        return new SettingsModel();
    }

    protected function settingsHtml(): ?string
    {
        $view = Craft::$app->getView();

        return $view->renderTemplate('weather/settings', [
            'settings' => $this->getSettings(),
        ]);
    }
}
