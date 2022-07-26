# Open Weather Plugin for Craft CMS

This plugin accesses the Open Weather Map API with a valid/working Open Weather API Key. The plugin will provide a small subset of data from the Current Weather API.

## Usage
### `{{ set weather = craft.weather.getWeather() }}`
Get current weather conditions for a single location based on settings applied. Then use the following variables for template output.

### `{{ weather.location }}`
The location name based on the latitude and longitude values given.

### `{{ weather.temp }}`
This will output a rounded integer based on the unit selected from settings (F/C).

### `{{ weather.unit }}`
This will output the proper unit of measurement.

### `{{ weather.iconUrl }}`
Open Weather provides simple icons for different weather conditions. This is that icons source URL.