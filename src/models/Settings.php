<?php

namespace simplygoodwork\weather\models;

use craft\base\Model;

class Settings extends Model
{
    public ?string $apiKey = null;

    public ?string $units = null;

    public ?string $lat = null;

    public ?string $lon = null;
}
