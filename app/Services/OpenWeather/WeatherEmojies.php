<?php

declare(strict_types=1);

namespace App\Services\OpenWeather;

interface WeatherEmojies
{
    public const NOTIFICATION = "\xf0\x9f\x94\x89";
    public const TEMPERATURE = "\xf0\x9f\x8c\xa1";
    public const HUMIDITY = "\xf0\x9f\x92\xa7";
    public const WIND = "\xf0\x9f\x8c\xac";
    public const PRESSURE = "\xf0\x9f\x94\xbb";
    public const MIN_TEMPERATURE = "\xee\x88\xb8";
    public const MAX_TEMPERATURE = "\xee\x88\xb6";
    public const SUNSET = "\xf0\x9f\x8c\x84";
    public const SUNRISE = "\xee\x91\x89";
    public const FOG = "\xf0\x9f\x8c\xab";
    public const MIST = "\xf0\x9f\x8c\xab";
    public const CLOUDS = "\xee\x81\x89";
    public const CLEAR = "\xf0\x9f\x8c\x9e";
    public const RAIN = "\xe2\x98\x94";
    public const SNOW = "\xe2\x9d\x84\xef\xb8\x8f";
}
