<?php

namespace simplygoodwork\weather\models;

use craft\base\Model;

class LocationModel extends Model
{
    public ?string $lat = null;
    public ?string $lon = null;
    public ?string $units = null;
    public ?string $cache = null;
}